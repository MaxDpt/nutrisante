window.onload = () => {

    navMenu();
    TablePage();
    GetClass();
    GetFormClass();
    deleteConfirm();

    console.log("hello");

function navMenu() {
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
            let urlPage = (Url.search).split('?userTablePage=')[1];

            // récupération de la page courante
            let userPage = urlPage ? parseInt(urlPage) : 1;

            // creation des parametre url (queryString)
            const Params = new URLSearchParams();
            let ParamsAttr = null

            if (button.id == "usersPrev") { Params.append("userTablePage", userPage -1),
                                            ParamsAttr = "user"}
            if (button.id == "usersNext") { Params.append("userTablePage", userPage +1),
                                            ParamsAttr = "user"}
            if (button.id == "usersPageItem") { Params.append("userTablePage", parseInt(button.value)),
                                            ParamsAttr = "user"}

            // requete AJAX 
            fetch(Url.pathname + "?" + Params.toString()+ "&ajax=1", {
                headers: {
                    "x-Requested-With": "XMLHttpRequest"
                }
                }).then(response => 
                response = response.json()
        
                ).then(data => {
                // mise à jours du contenue de la table utilisateur
                if (ParamsAttr = "user") {
                const content = document.querySelector(".users_table_content"); 
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
 
             // requete AJAX 
             fetch("/user"+ "?" + Params.toString()+ "&ajax=1", {
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
    document.querySelectorAll(".info-button #info_update").forEach(button => {
        button.addEventListener("click", () => { 
            // creation des parametre url (queryString)
            const Params = new URLSearchParams();

            // récupération de l'url courante
            const Url = new URL(window.location.href);

            if (button.id == "info_update") { Params.append("userid", button.value),
                                              ParamsAttr = "user"}

            // requete AJAX 
            fetch("/user/update"+ "?" + Params.toString()+ "&ajax=1", {
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

            // récupération de l'url courante
            const Url = new URL(window.location.href);

            // requete AJAX 
            fetch("/user/set"+ "?" + "&ajax=1", {
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
