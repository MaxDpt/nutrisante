window.onload = () => {
    // ----> NAVIGATION :
    document.querySelectorAll(".admin_nav button").forEach(button => {
        button.addEventListener("click", () => { 
            let pageValue = document.querySelector("pageValue")
            pageValue = parseInt(button.value)

            // creation des parametre url (queryString)
            const Params = new URLSearchParams();

            Params.append("pageValue", pageValue);

            // récupération de l'url courante
            const Url = new URL(window.location.href);

            // requete AJAX 
            fetch(Url.pathname + "?" + Params.toString()+ "&ajax=1", {
                headers: {
                    "x-Requested-With": "XMLHttpRequest"
                }
                }).then(response => 
                response = response.json()
        
                ).then(data => {
                // mise à jours du contenue de la page
                const content = document.querySelector(".admin_content");
                content.innerHTML = data.content;
        
                // mise à jours de l'url 
                history.pushState({}, null, Url.pathname + "?" + Params.toString())
        
                }).catch(error => {
                console.log(error)
                })
        })
    })
}