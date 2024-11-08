#!/bin/bash
set -a
DOCK_PHP="docker compose exec php bin/console"

help() {
    echo -e "\e[1;37mList of commands:\e[m";
    echo -e "db \e[32mmigrate\e[m\t\t Execute database migrations";
    echo -e "db \e[32mdiff\e[m\t\t create entity diff to api/migrations";
    echo -e "db \e[32mquery\e[m <string>\t Query sql";
    echo "";
    echo -e "docker \e[32mup\e[m\t\t docker compose up ";
    echo -e "docker \e[32mbuild\e[m\t\t docker compose build ";
    echo -e "docker \e[32mdown\e[m\t\t docker compose down";
    echo -e "docker \e[32mlogs\e[m\t\t docker compose logs -f";
    echo "";
    echo -e "test\t\t\t ";
    echo "";
}

case $1 in
    "make")
        case $2 in
            "orm")
                $DOCK_PHP make:entity --api-resource
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
            *)
                help;
                ;;
        esac
        ;;

    "db")
            case $2 in
                "fixtures")
                    $DOCK_PHP doctrine:fixtures:load
                    ;;
                "drop")
                    $DOCK_PHP doctrine:database:drop --force
                    ;;
                "up")
                    $DOCK_PHP doctrine:database:create
                    ;;
                "refresh")
                    ./mk db drop;
                    ./mk db up;
                    ./mk db migrate;
                    ./mk db fixtures;
                    ;;
                "migrate")
                    shift 2
                    $DOCK_PHP doctrine:migrations:migrate $@
                    ;;

                "diff")
                    $DOCK_PHP doctrine:migrations:diff
                    ;;

                *)
                    help
                    ;;
            esac
        ;;

    "test")
        ;;

    *)
        if [[ $1 == "" ]]; then
            help
        else
            echo -e "\033[31mCommand \"$1\" not found\033[m";
            help
        fi
esac
