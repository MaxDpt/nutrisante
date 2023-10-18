window.onload = () => {
    navMenu();
    ListPage();
    GetClass();
    ListFilter();
    ListSearch();
    
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
        
                }).catch(error => {
                console.log(error)
                })
        })
    })
}
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
}