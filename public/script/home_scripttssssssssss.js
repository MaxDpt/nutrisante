window.onload = () => {
    console.log('hello');
    navMenu();
    ListPage();
    GetClass();
    ListFilter();
    ListSearch();
    scoreSelect();
    commentaryLoad();
    commentarySubmit();
    deleteConfirm();
    commentaryDelete();
    
function navMenu() {
    // ----> NAVIGATION :
    document.querySelectorAll(".home_nav button").forEach(button => {
        button.addEventListener("click", () => { 
            let pageValue = document.querySelector("pageValue")
            pageValue = button.value

            // creation des parametre url (queryString)
            const Params = new URLSearchParams();

            Params.append("window", pageValue);

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
                const content = document.querySelector(".home_content");
                content.innerHTML = data.content;
                ListPage();
                GetClass();
                ListFilter();
                ListSearch();
        
                // mise à jours de l'url 
                history.pushState({}, null, Url.pathname + "?" + Params.toString())
        
                }).catch(error => {
                console.log(error)
                })
        })
    })
}
function  ListPage() {
    // formulaire de filtre
    const filtersForm = document.querySelector(".users-filters");
    // ----> PAGINATION TABLE :
    document.querySelectorAll(".pagination button").forEach(button => {
        button.addEventListener("click",() => { 
            // récupération de l'url courante
            const Url = new URL(window.location.href);
            let urlPageRecipe = (Url.search).split('?recipesListPage=')[1];
            let urlPageservice = (Url.search).split('?servicesListPage=')[1];

            // récupération de la page courante
            let recipePage = urlPageRecipe ? parseInt(urlPageRecipe) : 1;
            let servicePage = urlPageservice ? parseInt(urlPageservice) : 1;


            // creation des parametre url (queryString)
            const Params = new URLSearchParams();
            let ParamsAttr = null

            if (button.id == "recipesPrev") { Params.append("recipesListPage", recipePage -1),
                                            document.querySelector('#recipes_pages').value = (recipePage -1)
                                            ParamsAttr = "recipe"
                                            if (document.querySelector("#diet_filter").checked == true ||
                                            document.querySelector("#allergen_filter").checked == true ) {
                                            // recupération des données du formulaire de filtre
                                            const Form = new FormData(filtersForm);
                                            Form.forEach((value, key) => {
                                                Params.append(key, value);})
                                            } }
            if (button.id == "recipesNext") { Params.append("recipesListPage", recipePage +1),
                                            document.querySelector('#recipes_pages').value = (recipePage +1)
                                            ParamsAttr = "recipe"
                                            if (document.querySelector("#diet_filter").checked == true ||
                                            document.querySelector("#allergen_filter").checked == true ) {
                                            // recupération des données du formulaire
                                            const Form = new FormData(filtersForm);
                                            Form.forEach((value, key) => {
                                                Params.append(key, value);})
                                            }
                                        }  
            
            if (button.id == "servicesPrev") { Params.append("servicesListPage", servicePage -1),
                                            document.querySelector('#services_pages').value = (servicePage -1)
                                            ParamsAttr = "service"}
            if (button.id == "servicesNext") { Params.append("servicesListPage", servicePage +1),
                                            document.querySelector('#services_pages').value = (servicePage +1)
                                            ParamsAttr = "service"}

            // requete AJAX 
            fetch(Url.pathname + "?" + Params.toString()+ "&ajax=1", {
                headers: {
                    "x-Requested-With": "XMLHttpRequest"
                }
                }).then(response => 
                response = response.json()
        
                ).then(data => {
                // mise à jours du contenue de la table recettes
                if (ParamsAttr == "recipe") {
                // activation des boutons
                if (recipes_pages.value > 1) { recipesPrev.disabled = false } 
                else { recipesPrev.disabled = true }
                if (recipes_pages.value < Math.ceil(data.totalRecipes / data.recipesLimit)) 
                { recipesNext.disabled = false } 
                else { recipesNext.disabled = true }
                // mise à jours du nombre total de pages
                recipes_totalPages.value =(Math.ceil(data.totalRecipes / data.recipesLimit));
                // selection du container
                const content = document.querySelector(".recipes_list_content"); 
                content.innerHTML = data.content;
                GetClass();
                ListSearch(); }

                // mise à jours du contenue de la table service
                if (ParamsAttr == "service") {               
                // activation des boutons
                if (services_pages.value > 1) { servicesPrev.disabled = false } 
                else { servicesPrev.disabled = true }
                if (services_pages.value < Math.ceil(data.totalservices / data.servicesLimit)) 
                { servicesNext.disabled = false } 
                else { servicesNext.disabled = true }
                // mise à jours du nombre total de pages
                services_totalPages.value = (Math.ceil(data.totalservices / data.servicesLimit));
                    const content = document.querySelector(".services_list_content"); 
                    content.innerHTML = data.content;
                    GetClass();
                    ListSearch(); }
        
                // mise à jours de l'url 
                history.pushState({}, null, Url.pathname + "?" + Params.toString())
        
                }).catch(error => {
                console.log(error)
                })
        }) 
    })
} 
function GetClass() {
    // ----> NAVIGATION :
    if (document.querySelector(".class_btn")) {
    document.querySelectorAll(".class_btn button").forEach(button => {
        button.addEventListener("click", () => { 
            // creation des parametre url (queryString)
            const Params = new URLSearchParams();

            // récupération de l'url courante
            const Url = new URL(window.location.href);

            if (button.id == "recipeClass") { Params.append("recipeid", button.value),
                                            ParamsAttr = "recipes"}

            // requete AJAX 
            fetch("/"+ParamsAttr+ "?" + Params.toString()+ "&ajax=1", {
                headers: {
                    "x-Requested-With": "XMLHttpRequest"
                }
                }).then(response => 
                response = response.json()
        
                ).then(data => {
                // mise à jours du contenue de la page
                const content = document.querySelector(".home_content");
                content.innerHTML = data.content;
        
                // mise à jours de l'url 
                history.pushState({}, null, Url.pathname + "?" + Params.toString())
                // appel aux fonctions
                scoreSelect();
                commentaryLoad();
                commentarySubmit();
                deleteConfirm();
                commentaryDelete();
        
                }).catch(error => {
                console.log(error)
                })
        })
    })
}}
function ListFilter() {
    if (document.querySelectorAll(".users-filters input")) {
    const filtersForm = document.querySelector(".users-filters");
    document.querySelectorAll(".users-filters input").forEach(input => {
        input.addEventListener("change", () => { 
            // récupération de l'url courante
            const Url = new URL(window.location.href);

            // creation des parametre url (queryString)
            const Params = new URLSearchParams();

            // recupération des données du filtre
            const Form = new FormData(filtersForm);
            Form.forEach((value, key) => {
                Params.append(key, value);
            })
            // recupération des données de la recherche
            if (document.querySelector("#search_input").value) {
                Params.append('search', document.querySelector("#search_input").value)
            }
            if (document.querySelector("#diet_filter").checked == true ||
                document.querySelector("#allergen_filter").checked == true ) {
            // mise à jour de la page à 1      
            document.querySelector('#recipes_pages').value = (1)
            // requete AJAX 
            fetch(Url.pathname + "?" + Params.toString()+ "&ajax=1", {
                headers: {
                    "x-Requested-With": "XMLHttpRequest"
                }
                }).then(response => 
                response = response.json()
        
                ).then(data => {
                // activation des boutons
                if (recipes_pages.value > 1) { recipesPrev.disabled = false } 
                else { recipesPrev.disabled = true }
                if (recipes_pages.value < Math.ceil(data.totalRecipes / data.recipesLimit)) 
                { recipesNext.disabled = false } 
                else { recipesNext.disabled = true }
                // mise à jours du nombre total de pages
                recipes_totalPages.value =(Math.ceil(data.totalRecipes / data.recipesLimit));
                // mise à jours du contenue de la page
                const content = document.querySelector(".recipes_list_content");
                content.innerHTML = data.content;
                // mise à jours de l'url 
                history.pushState({}, null, Url.pathname + "?" + Params.toString())
        
                }).catch(error => {
                console.log(error)
                }) } else {
            // requete AJAX 
            fetch(Url.pathname + "?" + Params.toString() + '&filters=null' + "&ajax=1", {
                headers: {
                    "x-Requested-With": "XMLHttpRequest"
                }
                }).then(response => 
                response = response.json()
        
                ).then(data => {
                // activation des boutons
                if (recipes_pages.value > 1) { recipesPrev.disabled = false } 
                else { recipesPrev.disabled = true }
                if (recipes_pages.value < Math.ceil(data.totalRecipes / data.recipesLimit)) 
                { recipesNext.disabled = false } 
                else { recipesNext.disabled = true }
                // mise à jours du nombre total de pages
                recipes_totalPages.value = (Math.ceil(data.totalRecipes / data.recipesLimit));
                // mise à jours du contenue de la page
                const content = document.querySelector(".recipes_list_content");
                content.innerHTML = data.content;
                // mise à jours de l'url 
                history.pushState({}, null, Url.pathname + "?" + Params.toString())
        
                }).catch(error => {
                console.log(error)
                })
                }
        }) 
    }) }
}
function ListSearch() {
    if (document.querySelector("#search_btn")) {
    const filtersForm = document.querySelector(".users-filters");
    document.querySelector("#search_btn").addEventListener("click", () => {
        // récupération de l'url courante
        const Url = new URL(window.location.href);

        // creation des parametre url (queryString)
        const Params = new URLSearchParams();

        // initialisation du paramètre
        Params.append('search', document.querySelector("#search_input").value)
        if (document.querySelector("#diet_filter").checked == true || 
        document.querySelector("#allergen_filter").checked == true ) {
            // recupération des données du filtre
            const Form = new FormData(filtersForm);
            Form.forEach((value, key) => {
                Params.append(key, value);
            })
        }
        // mise à jour de la page à 1      
        document.querySelector('#recipes_pages').value = (1)

        fetch(Url.pathname + "?" + Params.toString()+ "&ajax=1", {
            headers: {
                "x-Requested-With": "XMLHttpRequest"
            }
            }).then(response => 
            response = response.json()
    
            ).then(data => {
            // activation des boutons
            if (recipes_pages.value > 1) { recipesPrev.disabled = false } 
            else { recipesPrev.disabled = true }
            if (recipes_pages.value < Math.ceil(data.totalRecipes / data.recipesLimit)) 
            { recipesNext.disabled = false } 
            else { recipesNext.disabled = true }
            // mise à jours du nombre total de pages
            recipes_totalPages.value = (Math.ceil(data.totalRecipes / data.recipesLimit));
            // mise à jours du contenue de la page
            const content = document.querySelector(".recipes_list_content");
            content.innerHTML = data.content;
            // mise à jours de l'url 
            history.pushState({}, null, Url.pathname + "?" + Params.toString())
    
            }).catch(error => {
            console.log(error)
            })
    }) }
}
function scoreSelect() {
    if (document.querySelectorAll(".score_form")) {
    // toutes les etoiles
    const stars = document.querySelectorAll(".star-form");
    // la note
    const note = document.querySelector('.score');
    // ecouteurs evenements des etoiles
    for(star of stars) {
        star.style.color = "white";
        // le survol
        star.addEventListener("mouseover", function(){
            resetStars();
            this.style.color = "orange";

            // element précendent dans le DOM
            let previousStar = this.previousElementSibling;
            while(previousStar) {
              previousStar.style.color = "orange";
              previousStar = previousStar.previousElementSibling;
            }
        });
        star.addEventListener("click", function(){
            note.value = this.dataset.value;
        });
        star.addEventListener('mouseout', function(){
            resetStars(note.value);
        });
    }
    // reset star
    function resetStars(note = 0) {
        for(star of stars) {
            if (star.dataset.value > note) {
                star.style.color = "white";
            } else {
                star.style.color = "orange";
            }
        }
    }
}
}
function commentaryLoad() {
if (document.querySelector('.commentary_load')) {
    document.querySelector('.commentary_load a').addEventListener('click', () => {
        // récupération de l'url courante
        const Url = new URL(window.location.href);
        // creation des parametre url (queryString)
        const Params = new URLSearchParams(Url.search);

        let recipeId = Params.get('recipeid');
        let urlCommentaryLimit = Params.get('commentaryLimit');
        let commentaryLimit = urlCommentaryLimit ? urlCommentaryLimit : 4;
        let newCommentaryLimit = parseInt(commentaryLimit) + 4;

        Params.delete("commentaryLimit");
        Params.append("commentaryLimit", newCommentaryLimit);

    fetch('/commentary/get' + "?" + Params.toString() + "&ajax=1", {
        headers: {
            "x-Requested-With": "XMLHttpRequest"
        }
        }).then(response => 
        response = response.json()

        ).then(data => {
        // mise à jours du contenue de la page
        const content = document.querySelector(".commentary_list_content");
        content.innerHTML = data.content;
        // mise à jours de l'url 
        history.pushState({}, null, Url.pathname + "?" + Params.toString());

        // appel aux fonctions
        deleteConfirm();
        commentaryLoad();
        }).catch(error => {
        console.log(error)
        })

    })
}
}
function commentarySubmit() {
    if (document.querySelector(".commentary_form_content .submit")) {
        document.querySelector(".commentary_form_content .submit").addEventListener("click", (e) => {

        e.preventDefault();
        const Url = new URL(window.location.href);
        let recipeId = (Url.search).split('?recipeid=')[1];

        let name = document.querySelector(".commentary_form_content form .name").value;
        let text = document.querySelector(".commentary_form_content form .text").value;
        let score = document.querySelector(".commentary_form_content form .score").value;

    // requete AJAX 
       fetch("/commentary/set" +'?'+ 'name='+ name +'&'+'score='+ score +'&'+'recipeid=' + recipeId + "&ajax=1", {
           method: 'POST',
           headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset:utf-8',
           },
           body: text
           
           }).then(response => 
           response = response.json()

           ).then(data => {
           // mise à jours du contenue de la page
           const content = document.querySelector(".commentary_list_content");
           content.innerHTML = data.content;

           // mise à jours de l'url 
           history.pushState({}, null, Url.pathname + '?' + 'recipeid=' + recipeId)

           // appel aux fonctions
           deleteConfirm();
           commentaryDelete();

           }).catch(error => {
           console.log(error)
           })
    }) }
}
function deleteConfirm() {
    if (document.querySelector('.commentary_delete')) { 
        document.querySelectorAll('.commentary_delete button').forEach(button => {
            button.addEventListener('click', () => { 
                document.querySelector(".confirm_content").hidden = false
                // récupération de l'url courante
                const Url = new URL(window.location.href);
                // creation des parametre url (queryString)
                const Params = new URLSearchParams(Url.search);
                Params.append('commentaryId', button.value)
                history.pushState({}, null, Url.pathname +'?'+ Params.toString());
            }) 
        })
        document.querySelector(".confirm_btn #cancel").addEventListener("click", () => {
            document.querySelector(".confirm_content").hidden = true
            // récupération de l'url courante
            const Url = new URL(window.location.href);
            // creation des parametre url (queryString)
            const Params = new URLSearchParams(Url.search);
            Params.delete('commentaryId');
            history.pushState({}, null, Url.pathname +'?'+ Params.toString());
        })
    }
}
function commentaryDelete() {
if (document.querySelector('.confirm_btn #delete')) {
    document.querySelector('.confirm_btn #delete').addEventListener('click', () => {
        // récupération de l'url courante
        const Url = new URL(window.location.href);
        // creation des parametre url (queryString)
        const Params = new URLSearchParams(Url.search);

        fetch('/commentary/delete' + "?" + Params.toString() + "&ajax=1", {
            headers: {
                "x-Requested-With": "XMLHttpRequest"
            }
            }).then(response => 
            response = response.json()
    
            ).then(data => {
            // mise à jours du contenue de la page
            const content = document.querySelector(".commentary_list_content");
            content.innerHTML = data.content;
            // mise à jours de l'url 
            Params.delete('commentaryId');
            history.pushState({}, null, Url.pathname + '?' + Params.toString() );
            document.querySelector(".confirm_content").hidden = true
            commentaryLoad();
            }).catch(error => {
            console.log(error)
            })

        })
}
}
}