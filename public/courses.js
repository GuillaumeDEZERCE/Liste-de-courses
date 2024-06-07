console.log("fichier chargé");

const courses = {

    // On stock le formulaire
    shListForm: document.querySelector(".shlist__form"),    


    // Sert à démarrer le module
    init: function( listName = "courses" ){
        
        // Récupérer le span dans mon h1
        const nomListe = document.querySelector('.shlist__title span');

        // Ajouter le texte à l'interieur de cette balise
        nomListe.textContent = listName;

        // On initialise les évènements
        courses.initEvents();
        console.log("La liste est prête à l'emploi");

        
    },

    // initialise tous les eventsListener
    initEvents: function(){
        courses.shListForm.addEventListener("submit", courses.handleSubmit )
    },

    // La fonction qui est appelée lors de la soumission du form
    handleSubmit: function(event){
        // On annule le comportement par défaut
        event.preventDefault();

        // Récupérer la valeur saisie par l'utlisateur
        // const value = document.querySelector(".shlist__input").value; -> condensé
        const input = document.querySelector(".shlist__input");
        const value = input.value;

        // On ajoute l'élément à la liste
        courses.add(value);

        // On réinitialise le champ input
        input.value = "";
    },

    // Méthode qui ajoute des éléments
    add: function( item ){

        // Récupérer la balise de la liste d'articles
        const articles = document.querySelector('.shlist__articles');

        // Créer une balise paragraphe
        const pElem = document.createElement("p");
        
        // Ajouter le texte au paragraphe
        pElem.textContent = item;

        // Insérer le paragraphe dans la balise 'articles'
        articles.append(pElem);

    },

}


// On va initialiser notre module une fois le DOM chargé
document.addEventListener( "DOMContentLoaded", function(){
    courses.init("courses");
})