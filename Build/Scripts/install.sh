#! /bin/bash
# coloring https://stackoverflow.com/questions/5947742/how-to-change-the-output-color-of-echo-in-linux
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# handling arguments
checkIfInstallNecessary=0

for variable in "$@"
do
    case "${variable}" in
        check) checkIfInstallNecessary=1
        ;;
    esac
done

# if "check" parameter given, check first before install
if [ "$checkIfInstallNecessary" = "1" ]
  then
    if [ -d ".ddev/commands" ] && [ -d ".Build/public" ];
      then
        printf "${GREEN}-> Install check: project setup is ready.${NC}\n"
        exit 0
    fi
fi

# do not double start this script:
if test -f "./Build/INSTALLATION_RUNNING";
  then
    exit
fi

# blocking other scripts while intall process
touch ./Build/INSTALLATION_RUNNING


########################
##### Start DDEV   #####
printf "${GREEN}-> Run ddev start while install process...${NC}\n"
ddev start

# run composer on ddev
printf "${GREEN}-> Run composer install...${NC}\n"
ddev composer install

ddev exec .Build/bin/typo3 setup --no-interaction \
    --driver="mysqli" \
   --username="db" \
   --host="db" \
   --port="3306" \
   --dbname="db" \
   --password="db" \
   --admin-username="contentblocks" \
   --admin-user-password="TYPO3-Contentblocks-GUI-12" \
   --admin-email="mail@localhost.com" \
   --project-name="ContentBlocksGUI" \
   --create-site="https://content-blocks-gui.ddev.site/" \

ddev exec .Build/bin/typo3 database:updateschema

# stop blocking other scripts while intall process
rm ./Build/INSTALLATION_RUNNING
printf "${GREEN}Setup ready.${NC}\n"
