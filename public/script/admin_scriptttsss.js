window.onload = () => {

    console.log("hello");
    navMenu();
    TablePage();
    GetClass();
    GetFormClass();
    deleteConfirm();

function navMenu() {
    // ----> NAVIGATION :
    document.querySelectorAll(".admin_nav button").forEach(button => {
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
                const content = document.querySelector(".admin_content");
                content.innerHTML = data.content;
                TablePage();
                GetClass();
                GetFormClass();
        
                // mise à jours de l'url 
                history.pushState({}, null, Url.pathname + "?" + Params.toString())
        
                }).catch(error => {
                console.log(error)
                })
        })
    })
}

function  TablePage() {
    // ----> PAGINATION TABLE :
    document.querySelectorAll(".pagination button").forEach(button => {
        button.addEventListener("click",() => { 
            // récupération de l'url courante
            const Url = new URL(window.location.href);
            let urlPageUser = (Url.search).split('?userTablePage=')[1];
            let urlPageRecipe = (Url.search).split('?recipesTablePage=')[1];
            let urlPageservice = (Url.search).split('?servicesTablePage=')[1];
            let urlPagemessage = (Url.search).split('?messagesTablePage=')[1];

            // récupération de la page courante
            let userPage = urlPageUser ? parseInt(urlPageUser) : 1;
            let recipePage = urlPageRecipe ? parseInt(urlPageRecipe) : 1;
            let servicePage = urlPageservice ? parseInt(urlPageservice) : 1;
            let messagePage = urlPagemessage ? parseInt(urlPagemessage) : 1;

            // creation des parametre url (queryString)
            const Params = new URLSearchParams();
            let ParamsAttr = null

            if (button.id == "usersPrev") { Params.append("userTablePage", userPage -1),
                                            ParamsAttr = "user"}
            if (button.id == "usersNext") { Params.append("userTablePage", userPage +1),
                                            ParamsAttr = "user"}
            if (button.id == "usersPageItem") { Params.append("userTablePage", parseInt(button.value)),
                                            ParamsAttr = "user"}

            if (button.id == "recipesPrev") { Params.append("recipesTablePage", recipePage -1),
                                            ParamsAttr = "recipe"}
            if (button.id == "recipesNext") { Params.append("recipesTablePage", recipePage +1),
                                            ParamsAttr = "recipe"}
            if (button.id == "recipesPageItem") { Params.append("recipesTablePage", parseInt(button.value)),
                                            ParamsAttr = "recipe"}   
            
            if (button.id == "servicesPrev") { Params.append("servicesTablePage", servicePage -1),
                                            ParamsAttr = "service"}
            if (button.id == "servicesNext") { Params.append("servicesTablePage", servicePage +1),
                                            ParamsAttr = "service"}
            if (button.id == "servicesPageItem") { Params.append("servicesTablePage", parseInt(button.value)),
                                            ParamsAttr = "service"} 

            if (button.id == "messagesPrev") { Params.append("messagesTablePage", messagePage -1),
                                            ParamsAttr = "message"}
            if (button.id == "messagesNext") { Params.append("messagesTablePage", messagePage +1),
                                            ParamsAttr = "message"}
            if (button.id == "messagesPageItem") { Params.append("messagesTablePage", parseInt(button.value)),
                                            ParamsAttr = "message"} 

            // requete AJAX 
            fetch(Url.pathname + "?" + Params.toString()+ "&ajax=1", {
                headers: {
                    "x-Requested-With": "XMLHttpRequest"
                }
                }).then(response => 
                response = response.json()
        
                ).then(data => {
                // mise à jours du contenue de la table utilisateur
                if (ParamsAttr == "user") {
                const content = document.querySelector(".users_table_content"); 
                content.innerHTML = data.content;
                GetClass();
                GetFormClass(); }
                // mise à jours du contenue de la table ingredient
                if (ParamsAttr == "recipe") {
                const content = document.querySelector(".recipes_table_content"); 
                content.innerHTML = data.content;
                GetClass();
                GetFormClass(); }
                // mise à jours du contenue de la table service
                if (ParamsAttr == "service") {
                    const content = document.querySelector(".services_table_content"); 
                    content.innerHTML = data.content;
                    GetClass();
                    GetFormClass(); }
                // mise à jours du contenue de la table message
                if (ParamsAttr == "message") {
                    const content = document.querySelector(".messages_table_content"); 
                    content.innerHTML = data.content;
                    GetClass();
                    GetFormClass(); }
        
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
     document.querySelectorAll(".table button").forEach(button => {
         button.addEventListener("click", () => { 
             // creation des parametre url (queryString)
             const Params = new URLSearchParams();
 
             // récupération de l'url courante
             const Url = new URL(window.location.href);
 
             if (button.id == "userClass") { Params.append("userid", button.value),
                                             ParamsAttr = "user"}
             if (button.id == "recipeClass") { Params.append("recipeid", button.value),
                                             ParamsAttr = "recipes"}
            if (button.id == "serviceClass") { Params.append("serviceid", button.value),
                                             ParamsAttr = "service"}
            if (button.id == "messageClass") { Params.append("messageid", button.value),
                                             ParamsAttr = "message"}
 
             // requete AJAX 
             fetch("/"+ParamsAttr+ "?" + Params.toString()+ "&ajax=1", {
                 headers: {
                     "x-Requested-With": "XMLHttpRequest"
                 }
                 }).then(response => 
                 response = response.json()
         
                 ).then(data => {
                 // mise à jours du contenue de la page
                 const content = document.querySelector(".admin_content");
                 content.innerHTML = data.content;
                 GetFormClass();
                 deleteConfirm(); 
         
                 // mise à jours de l'url 
                 history.pushState({}, null, Url.pathname + "?" + Params.toString())
         
                 }).catch(error => {
                 console.log(error)
                 })
         })
     })
 }

 function GetFormClass() {
    // ----> NAVIGATION :
    document.querySelectorAll(".info-button .update").forEach(button => {
        button.addEventListener("click", () => { 
            // creation des parametre url (queryString)
            const Params = new URLSearchParams();
            let ParamsAttr = null

            // récupération de l'url courante
            const Url = new URL(window.location.href);

            if (button.id == "info_update_user") { Params.append("userid", button.value),
                                              ParamsAttr = "user"}
            if (button.id == "info_update_recipe") { Params.append("recipeid", button.value),
                                              ParamsAttr = "recipes"}
            if (button.id == "info_update_service") { Params.append("serviceid", button.value),
                                              ParamsAttr = "service"}

            // requete AJAX 
            fetch("/"+ ParamsAttr +"/update"+ "?" + Params.toString()+ "&ajax=1", {
                headers: {
                    "x-Requested-With": "XMLHttpRequest"
                }
                }).then(response => 
                response = response.json()
        
                ).then(data => {
                // mise à jours du contenue de la page
                const content = document.querySelector(".admin_content");
                content.innerHTML = data.content;
                TablePage();
        
                // mise à jours de l'url 
                history.pushState({}, null, Url.pathname + "?" + Params.toString())
        
                }).catch(error => {
                console.log(error)
                })
        })
    })
    document.querySelectorAll(".new_btn button").forEach(button => {
        button.addEventListener("click", () => { 
            let ParamsAttr = null

            // récupération de l'url courante
            const Url = new URL(window.location.href);

            if (button.id == "new_user") { ParamsAttr = "user" }
            if (button.id == "new_recipes") { ParamsAttr = "recipes" }
            if (button.id == "new_service") { ParamsAttr = "service" }

            // requete AJAX 
            fetch("/"+ ParamsAttr +"/set"+ "?" + "&ajax=1", {
                headers: {
                    "x-Requested-With": "XMLHttpRequest"
                }
                }).then(response => 
                response = response.json()
        
                ).then(data => {
                // mise à jours du contenue de la page
                const content = document.querySelector(".admin_content");
                content.innerHTML = data.content;
                TablePage();
        
                // mise à jours de l'url 
                history.pushState({}, null, Url.pathname )
        
                }).catch(error => {
                console.log(error)
                })
        })
    })
}
function deleteConfirm() {
    document.querySelector(".info-button #info_delete").addEventListener("click", () => {
        document.querySelector(".confirm_content").hidden = false
    })
    document.querySelector(".confirm_btn #cancel").addEventListener("click", () => {
        document.querySelector(".confirm_content").hidden = true
    })
}
}
