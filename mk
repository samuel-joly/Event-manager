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
                    shift
                    case $2 in
                        "load")
                            $DOCK_PHP doctrine:fixtures:load
                            ;;
                    esac
                    ;;
                "drop")
                        ./mk db clear;
                        ./mk db query "drop table reservation;drop table room; drop table login;"
                    ;;
                "clear")
                        ./mk db query "delete from reservation;delete from room; delete from login;"
                    ;;
                "query")
                    shift
                    if [[ $2 == "root" ]]; then
                        docker exec $container sh -c "mysql -uroot -p$DB_PASSWORD -D $DB_NAME -e \"$3\"";
                    else
                        docker exec $container sh -c "mysql -u$DB_USER -p$DB_PASSWORD -D $DB_NAME -e \"$2\"";
                    fi;
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
