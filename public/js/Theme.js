/**
 * La classe qui stocke les données d'un theme
 */
class Theme 
{
    /**
     * le nom du theme
     *  @type {string}
    */
    name = "custom theme";
    /**
     * la police du text
     * @type {string}
    */
    font = "";
    /**
     * la taille du text
     * @type {number}
    */
    font_size = 16;

    /*Les couleurs du site*/

    /**
     * 
     * @param {string} name nom du theme
     */
    constructor(name) 
    {
        this.name = name;
    }

    /**
     * verifie si les valeures du theme sont valide ou pas
     *  - si elles sont valides: ne change rien et retourn true
     *  - si elles sont invalides: corrige les valeures et retourn true
     *  - si document est null: retourn false et ne corrige rien. 
     * @returns {boolean} la verification a pu etre effectuée.
     */
    CheckValues()
    {
        if (document != null)
        {
            if (!document.fonts.check(this.font)) this.font = "[default-font]";
            if (this.font_size <= 0) this.font_size = 1;

            return true;
        }

        return false;
    }
}
  
