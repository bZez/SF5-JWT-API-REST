git pull

echo "--------- add . ------"
git add .

echo "--------- commit -m ------"
git commit -m "$1"


echo "--------- push ------"
git push

echo "--------- push ------"
git ftp push


echo "******* Done ! ********"

