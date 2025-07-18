// Script de débogage pour le système SPA
const SPADebug = {
    init: () => {
        console.log('🔍 SPADebug initialisé');
        SPADebug.attachDebugListeners();
        SPADebug.logPageLoad();
    },

    attachDebugListeners: () => {
        // Écouter les changements de page
        const originalChargerPage = window.chargerPage;
        window.chargerPage = async (page, addHistory = true) => {
            console.log('🔄 Navigation vers:', page);
            console.log('📊 État avant navigation:', {
                currentUrl: window.location.href,
                contentElement: document.getElementById('content')?.innerHTML?.length || 0,
                stylesheets: document.styleSheets.length
            });
            
            try {
                await originalChargerPage(page, addHistory);
                console.log('✅ Navigation réussie vers:', page);
                SPADebug.logPageLoad();
            } catch (error) {
                console.error('❌ Erreur de navigation:', error);
            }
        };
    },

    logPageLoad: () => {
        console.log('📋 État de la page:', {
            url: window.location.href,
            title: document.title,
            contentLength: document.getElementById('content')?.innerHTML?.length || 0,
            darkMode: document.documentElement.classList.contains('dark'),
            stylesheets: Array.from(document.styleSheets).map(sheet => sheet.href || 'inline'),
            scripts: Array.from(document.scripts).map(script => script.src || 'inline')
        });
        
        // Vérifier les éléments importants
        const importantElements = [
            'content',
            'sidebar',
            '.profile-photo',
            '.cover-photo',
            '.notification-btn'
        ];
        
        importantElements.forEach(selector => {
            const element = document.querySelector(selector);
            if (element) {
                console.log(`✅ Élément trouvé: ${selector}`);
            } else {
                console.log(`❌ Élément manquant: ${selector}`);
            }
        });
    },

    checkStyles: () => {
        console.log('🎨 Vérification des styles:');
        
        // Vérifier les classes Tailwind
        const tailwindClasses = [
            'bg-gray-200', 'dark:bg-gray-800', 'text-white', 'dark:text-white',
            'rounded-lg', 'shadow', 'hover:bg-gray-100', 'dark:hover:bg-gray-700'
        ];
        
        tailwindClasses.forEach(className => {
            const elements = document.querySelectorAll(`.${className}`);
            if (elements.length > 0) {
                console.log(`✅ Classe ${className} trouvée sur ${elements.length} élément(s)`);
            } else {
                console.log(`⚠️ Classe ${className} non trouvée`);
            }
        });
    },

    forceReload: () => {
        console.log('🔄 Forçage du rechargement...');
        
        // Forcer le rechargement des styles
        document.body.offsetHeight;
        
        // Recharger les classes Tailwind
        const elements = document.querySelectorAll('*');
        elements.forEach(element => {
            const classes = element.className.split(' ');
            classes.forEach(className => {
                if (className.includes('bg-') || className.includes('text-') || className.includes('border-')) {
                    element.classList.add(className);
                }
            });
        });
        
        console.log('✅ Rechargement forcé terminé');
    }
};

// Initialiser le débogage
if (typeof window !== 'undefined') {
    window.SPADebug = SPADebug;
    document.addEventListener('DOMContentLoaded', () => {
        SPADebug.init();
    });
}

// Fonctions utilitaires pour le débogage
window.debugSPA = {
    checkStyles: SPADebug.checkStyles,
    forceReload: SPADebug.forceReload,
    logPageLoad: SPADebug.logPageLoad
}; 