#!/bin/bash
set -a
DOCK_PHP="docker compose exec php "
ROOT=$PWD

help() {
    echo -e "\e[1;37mList of commands:\e[m";
    echo -e "db \e[32mmigration\e[m up \t\t";
    echo -e "db \e[32mmigration\e[m down \t\t";
    echo -e "db \e[32mmigrate\e[m\t\t Execute database migrations";
    echo -e "db \e[32mdiff\e[m\t\t create entity diff to api/migrations";
    echo -e "db \e[32mquery\e[m <string>\t Query sql";
    echo "";
    echo -e "docker \e[32mup\e[m\t\t docker compose up ";
    echo -e "docker \e[32mbuild\e[m\t\t docker compose build ";
    echo -e "docker \e[32mdown\e[m\t\t docker compose down";
    echo -e "docker \e[32mlogs\e[m\t\t docker compose logs -f";
    echo -e "docker \e[32mremake\e[m\t\t drop all container/volumes/images";
    echo "";
    echo -e "test\t\t\t bin/phpunit ";
    echo "";
}

case $1 in
    "make")
        case $2 in
            "orm")
                $DOCK_PHP bin/console make:entity --api-resource
                ;;
            esac
        ;;
    "docker")
        case $2 in
            "build")
                shift 2
                docker compose build --no-cache
                ;;
            "logs")
                docker compose logs -f
                ;;
            "up")
                shift 2
                docker compose up --wait
                ;;
            "down")
                shift 2
                docker compose down $@
                ;;
            "remake")
                shift 2
                docker compose down $@
                docker container rm $(docker container ls -qa | grep $ROOT)
                docker image rm $(docker image ls -qa)
                docker volume rm $(docker volume ls -q )
                docker compose up $@
                ;;
            *)
                help;
                ;;
        esac
        ;;
    "migration")
        case $2 in
            "down")
                exa --no-user --no-permissions --no-time --no-filesize --oneline $ROOT/api/migrations | fzf --layout reverse --preview-window=right:80% --preview="bat -l PHP --color=always $ROOT/api/migrations/{1}" --bind "enter:become($DOCK_PHP bin/console doctrine:migrations:execute $ROOT/api/migrations/{1})"
                ;;
            "up")
                $DOCK_PHP bin/console doctrine:migrations:migrate $@
                ;;
        esac
        ;;

    "db")
            case $2 in
                "fixtures")
                    $DOCK_PHP bin/console doctrine:fixtures:load
                    ;;
                "drop")
                    $DOCK_PHP bin/console doctrine:database:drop --force
                    ;;
                "up")
                    $DOCK_PHP bin/console doctrine:database:create
                    ;;
                "refresh")
                    ./mk db drop;
                    ./mk db up;
                    ./mk db migrate;
                    ./mk db fixtures;
                    ;;
                "migrate")
                    shift 2
                    $DOCK_PHP bin/console doctrine:migrations:migrate $@
                    ;;

                "diff")
                    $DOCK_PHP bin/console doctrine:migrations:diff
                    ;;

                *)
                    help
                    ;;
            esac
        ;;
    "react")
        shift 1
        case $1 in
            "start")
                cd my-admin
                npm start &
                cd ..
                ;;
            "stop")
                ;;
            *)
                help
                ;;
        esac
        ;;

    "test")
        $DOCK_PHP bin/phpunit
        ;;

    *)
        if [[ $1 == "" ]]; then
            help
        else
            echo -e "\033[31mCommand \"$1\" not found\033[m";
            help
        fi
esac
