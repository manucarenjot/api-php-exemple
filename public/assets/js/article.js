
const sendArticle = document.querySelector('#add-article');

if(sendArticle) {

    sendArticle.addEventListener('click', () => {
        const xhr = new XMLHttpRequest();
        xhr.responseType = 'json';

        const body = {
            title: document.querySelector('#article-title').value,
            content: document.querySelector('#article-content').value
        };

        xhr.open('post', '/api/add-article.php');

        xhr.onload = function() {
            if(xhr.status === 404) {
                alert('Aucun enpoint trouvé !');
                return;
            }
            else if(xhr.status === 400) {
                alert('Un paramètre est manquant');
                return;
            }

            const response = xhr.response;
            console.log(response.id);
            console.log(response.title);
            console.log(response.content);
            console.log(response.author);
        }

        xhr.send(JSON.stringify(body));
    });
}


