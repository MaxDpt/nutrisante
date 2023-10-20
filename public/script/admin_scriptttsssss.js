window.onload = () => {

    console.log("hellooo");
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

            // récupération de la page courante
            let userPage = document.querySelector('#users_pages') ? document.querySelector('#users_pages').value : 1;
            let recipePage = document.querySelector('#recipes_pages') ? document.querySelector('#recipes_pages').value : 1;
            let servicePage = document.querySelector('#services_pages') ? document.querySelector('#services_pages').value : 1;
            let messagePage = document.querySelector('#messages_pages') ? document.querySelector('#messages_pages').value : 1;

            // creation des parametre url (queryString)
            const Params = new URLSearchParams();
            let ParamsAttr = null

            if (button.id == "usersPrev") { Params.append("userTablePage", parseInt(userPage) -1),
                                            document.querySelector('#users_pages').value = (parseInt(userPage) -1),
                                            ParamsAttr = "user"}
            if (button.id == "usersNext") { Params.append("userTablePage", parseInt(userPage) +1),
                                            document.querySelector('#users_pages').value = (parseInt(userPage) +1),
                                            ParamsAttr = "user"}

            if (button.id == "recipesPrev") { Params.append("recipesTablePage",  parseInt(recipePage) -1),
                                            document.querySelector('#recipes_pages').value = (parseInt(recipePage) -1),
                                            ParamsAttr = "recipe"}
            if (button.id == "recipesNext") { Params.append("recipesTablePage",  parseInt(recipePage) +1),
                                            document.querySelector('#recipes_pages').value = (parseInt(recipePage) +1),
                                            ParamsAttr = "recipe"} 
            
            if (button.id == "servicesPrev") { Params.append("servicesTablePage", parseInt(servicePage) -1),
                                            document.querySelector('#services_pages').value = (parseInt(servicePage) -1),
                                            ParamsAttr = "service"}
            if (button.id == "servicesNext") { Params.append("servicesTablePage", parseInt(servicePage) +1),
                                            document.querySelector('#services_pages').value = (parseInt(servicePage) +1),
                                            ParamsAttr = "service"}

            if (button.id == "messagesPrev") { Params.append("messagesTablePage", parseInt(messagePage) -1),
                                            document.querySelector('#messages_pages').value = (parseInt(messagePage) -1),
                                            ParamsAttr = "message"}
            if (button.id == "messagesNext") { Params.append("messagesTablePage", parseInt(messagePage) +1),
                                            document.querySelector('#messages_pages').value = (parseInt(messagePage) +1),
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
                // activation des boutons
                if (users_pages.value > 1) { usersPrev.disabled = false } 
                else { usersPrev.disabled = true }
                if (users_pages.value < Math.ceil(data.totalUsers / data.usersLimit)) 
                { usersNext.disabled = false } 
                else { usersNext.disabled = true }
                const content = document.querySelector(".users_table_content"); 
                content.innerHTML = data.content;
                GetClass();
                GetFormClass(); }

                // mise à jours du contenue de la table ingredient
                if (ParamsAttr == "recipe") {
                // activation des boutons
                if (recipes_pages.value > 1) { recipesPrev.disabled = false } 
                else { recipesPrev.disabled = true }
                if (recipes_pages.value < Math.ceil(data.totalRecipes / data.recipesLimit)) 
                { recipesNext.disabled = false } 
                else { recipesNext.disabled = true }   
                const content = document.querySelector(".recipes_table_content"); 
                content.innerHTML = data.content;
                GetClass();
                GetFormClass(); }

                // mise à jours du contenue de la table service
                if (ParamsAttr == "service") {
                // activation des boutons
                if (services_pages.value > 1) { servicesPrev.disabled = false } 
                else { servicesPrev.disabled = true }
                if (services_pages.value < Math.ceil(data.totalservices / data.servicesLimit)) 
                { servicesNext.disabled = false } 
                else { servicesNext.disabled = true }
                    const content = document.querySelector(".services_table_content"); 
                    content.innerHTML = data.content;
                    GetClass();
                    GetFormClass(); }
                    
                // mise à jours du contenue de la table message
                if (ParamsAttr == "message") {
                // activation des boutons
                if (messages_pages.value > 1) { messagesPrev.disabled = false } 
                else { messagesPrev.disabled = true }
                if (messages_pages.value < Math.ceil(data.totalmessages / data.messagesLimit)) 
                { messagesNext.disabled = false } 
                else { messagesNext.disabled = true }
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
            if (button.id == "cabinetClass") { Params.append("cabinetid", parseInt(1)),
                                             ParamsAttr = "cabinet"}
 
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
            if (button.id == "info_update_cabinet") { Params.append("cabinetid", button.value),
                                              ParamsAttr = "cabinet"}

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
