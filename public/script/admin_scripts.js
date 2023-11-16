window.onload = () => {
    navMenu();
    TablePage();
    GetClass();
    GetFormClass();
    addItemInForm();
    deleteConfirm();
    scoreSelect();
    commentaryLoad();
    commentarySubmit();
    deleteConfirm_commentary();
    commentaryDelete();

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

             if (Url.search && Url.search.split('=')[0] === '?userid') {
                Params.append("userid", Url.search.split('?userid=')[1])
             }
 
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
                 GetClass();
                 GetFormClass();
                 deleteConfirm(); 
                 scoreSelect();
                 commentaryLoad();
                 commentarySubmit();
                 deleteConfirm_commentary()
                 commentaryDelete();
         
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
                addItemInForm();
                userSearch();
        
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
                addItemInForm();
                userSearch();
        
                // mise à jours de l'url 
                history.pushState({}, null, Url.pathname )
        
                }).catch(error => {
                console.log(error)
                })
        })
    })
}
function addItemInForm() {
  if (document.querySelector('.form-group #recipes_diet') || document.querySelector('.form-group #users_diet')) {
    console.log('ok')
    // -- DIET -->
    const collectionHolder_diet_user = document.querySelector('.form-group #users_diet');
    let index_collectionHolder_diet_user = document.querySelectorAll('.form-group #users_diet input').length;
    // -- ALLERGEN -->
    const collectionHolder_allergen_user = document.querySelector('.form-group #users_allergen');
    let index_collectionHolder_allergen_user = document.querySelectorAll('.form-group #users_allergen input').length;
    // -- DIET -->
    const collectionHolder_diet = document.querySelector('.form-group #recipes_diet');
    let index_collectionHolder_diet = document.querySelectorAll('.form-group #recipes_diet input').length;
    // -- ALLERGEN -->
    const collectionHolder_allergen = document.querySelector('.form-group #recipes_allergen');
    let index_collectionHolder_allergen = document.querySelectorAll('.form-group #recipes_allergen input').length;
    // -- INGREDIENT -->
    const collectionHolder_ingredient = document.querySelector('.form-group #recipes_ingredient');
    let index_collectionHolder_ingredient = document.querySelectorAll('.form-group #recipes_ingredient input').length;
    // -- STAGE -->
    const collectionHolder_stage = document.querySelector('.form-group #recipes_stage');
    let index_collectionHolder_stage = document.querySelectorAll('.form-group #recipes_stage input').length;

    // -- NEW ITEM -->
    const new_item = document.querySelectorAll('.form-group .items_btn .new-item');
    new_item.forEach((button) => {
        button.addEventListener('click', () => {
          if (button.value === 'diet' && collectionHolder_diet_user) {
              collectionHolder_diet_user.innerHTML += collectionHolder_diet_user.dataset.prototype.replace(/__name__/g, parseInt(index_collectionHolder_diet_user) + 1).replace(/label__/g, "");
              index_collectionHolder_diet_user ++; 
              }
          if (button.value === 'allergen' && collectionHolder_allergen_user) {
            collectionHolder_allergen_user.innerHTML += collectionHolder_allergen_user.dataset.prototype.replace(/__name__/g, parseInt(index_collectionHolder_allergen_user) + 1).replace(/label__/g, "");
              index_collectionHolder_allergen_user ++; 
          }
          if (button.value === 'diet' && collectionHolder_diet) {
            collectionHolder_diet.innerHTML += collectionHolder_diet.dataset.prototype.replace(/__name__/g, parseInt(index_collectionHolder_diet) + 1).replace(/label__/g, "");
            index_collectionHolder_diet ++; 
          }
          if (button.value === 'allergen' && collectionHolder_allergen) {
            collectionHolder_allergen.innerHTML += collectionHolder_allergen.dataset.prototype.replace(/__name__/g, parseInt(index_collectionHolder_allergen) + 1).replace(/label__/g, "");
            index_collectionHolder_allergen ++; 
          }
          if (button.value === 'ingredient' && collectionHolder_ingredient) {
            collectionHolder_ingredient.innerHTML += collectionHolder_ingredient.dataset.prototype.replace(/__name__/g, parseInt(index_collectionHolder_ingredient) + 1).replace(/label__/g, "");
            index_collectionHolder_ingredient ++; 
          }
          if (button.value === 'stage' && collectionHolder_stage) {
            collectionHolder_stage.innerHTML += collectionHolder_stage.dataset.prototype.replace(/__name__/g, parseInt(index_collectionHolder_stage) + 1).replace(/label__/g, "");
            index_collectionHolder_stage ++; 
          }

        })
    })
    // -- DELETE ITEM -->
    const delete_item = document.querySelectorAll('.form-group .items_btn .delete-item');
    delete_item.forEach((button) => {
        button.addEventListener('click', () => {
            if (button.value === 'diet' && document.querySelectorAll('.form-group #users_diet div').length > 0) {
                let items = document.querySelectorAll('.form-group #users_diet div');
                items[items.length - 1].remove();
                index_collectionHolder_diet_user --;
            }
            if (button.value === 'allergen' && document.querySelectorAll('.form-group #users_allergen div').length > 0) {
                let items = document.querySelectorAll('.form-group #users_allergen div');
                items[items.length - 1].remove();
                index_collectionHolder_allergen_user --; 
            }
            if (button.value === 'diet' && document.querySelectorAll('.form-group #recipes_diet div').length > 0) {
                let items = document.querySelectorAll('.form-group #recipes_diet div');
                items[items.length - 1].remove();
                index_collectionHolder_diet --;
            }
            if (button.value === 'allergen' && document.querySelectorAll('.form-group #recipes_allergen div').length > 0) {
                let items = document.querySelectorAll('.form-group #recipes_allergen div');
                items[items.length - 1].remove();
                index_collectionHolder_allergen --; 
            }
            if (button.value === 'ingredient' && document.querySelectorAll('.form-group #recipes_ingredient div').length > 0) {
                let items = document.querySelectorAll('.form-group #recipes_ingredient div');
                items[items.length - 1].remove();
                index_collectionHolder_ingredient --;
            }
            if (button.value === 'stage' && document.querySelectorAll('.form-group #recipes_stage div').length > 0) {
                let items = document.querySelectorAll('.form-group #recipes_stage div');
                items[items.length - 1].remove();
                index_collectionHolder_stage --; 
            }
        })
    })
  }
}
function deleteConfirm() {
    if (document.querySelector(".info-button #info_delete")) {
    document.querySelector(".info-button #info_delete").addEventListener("click", () => {
        document.querySelector(".confirm_content").hidden = false
    })
    document.querySelector(".confirm_btn #cancel").addEventListener("click", () => {
        document.querySelector(".confirm_content").hidden = true
    }) 
}
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
        deleteConfirm_commentary();
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
           deleteConfirm_commentary();
           commentaryLoad();

           }).catch(error => {
           console.log(error)
           })
    }) }
}
function deleteConfirm_commentary() {
    if (document.querySelector('.commentary_delete')) { 
        document.querySelectorAll('.commentary_delete button').forEach(button => {
            button.addEventListener('click', () => { 
                document.querySelector(".confirm_commentary_content").hidden = false
                // récupération de l'url courante
                const Url = new URL(window.location.href);
                // creation des parametre url (queryString)
                const Params = new URLSearchParams(Url.search);
                Params.append('commentaryId', button.value)
                history.pushState({}, null, Url.pathname +'?'+ Params.toString());
            }) 
        })
        document.querySelector(".confirm_commentary_btn #cancel").addEventListener("click", () => {
            document.querySelector(".confirm_commentary_content").hidden = true
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
if (document.querySelector('.confirm_commentary_btn #delete')) {
    document.querySelector('.confirm_commentary_btn #delete').addEventListener('click', () => {
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
            document.querySelector(".confirm_commentary_content").hidden = true;
            deleteConfirm_commentary();
            commentaryLoad();
            }).catch(error => {
            console.log(error)
            })

        })
}
}
function userSearch() {
    if ( document.querySelector('.form-group #userSearch')) {
        let userSearch = document.querySelector('.form-group #userSearch');
        userSearch.addEventListener('input', () => {
            // récupération de l'url courante
            const Url = new URL(window.location.href);
            // creation des parametre url (queryString)
            const Params = new URLSearchParams(Url.search);
            Params.append('userSearch', userSearch.value);

            fetch('/users/search' + "?" + Params.toString() + "&ajax=1", {
                headers: {
                    "x-Requested-With": "XMLHttpRequest"
                }
                }).then(response => 
                response = response.json()
        
                ).then(data => {
                // mise à jours du contenue de la recherche
                const content = document.querySelector(".result_search_content");
                content.innerHTML = data.content;
                userSearch_select();

                }).catch(error => {
                console.log(error)
                })
        })
    }
}
function userSearch_select () {
    if (document.querySelector('.form-group .itemSearch')) {
    document.querySelectorAll('.form-group .itemSearch').forEach(a => {
        a.addEventListener("click", (e) => {
            e.preventDefault();
            document.querySelector('.form-group #recipes_user').value = a.name;
            document.querySelector('.form-group #userSearch').value = a.id;

            // mise à jours du contenue de la recherche
            const content = document.querySelector(".result_search_content");
            content.innerHTML = null;

        }) 
    })
    } 
}
}
