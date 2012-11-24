"use strict";
requirejs.config({

    baseUrl: 'http://project-rabbit/js',
    //baseUrl: 'http://www.artify.co/js',
    
    deps: ['main'],
    
    paths: {
        jQuery: 'libs/jquery',
        jQueryUi: 'libs/jquery-ui',
        tabs: 'bootstrap/bootstrap-tabs',
        dropdown: 'bootstrap/bootstrap-dropdown',
        jsonT: 'libs/jsont',
        Underscore: 'libs/underscore',
        Backbone: 'libs/backbone',
        Artify: 'artify',
        Utils: 'utils'
    },
    shim: {
    	jQuery: {
    		exports: 'jQuery'
    	},
    	jQueryUi: {
    		deps: ['jQuery']
    	},
    	tabs: {
    		deps: ['jQuery']
    	},
    	dropdown: {
    		deps: ['jQuery']
    	},
    	jsonT: {
    		exports: 'jsonT'
    	},
    	Underscore: {
    		deps: ['jQuery'],
    		exports: '_'
    	},
    	Backbone: {
    		deps: ['Underscore'],
    		exports: 'Backbone'
    	},
    	Artify: {
    		deps: ['jQuery', 'tabs', 'dropdown'],
    		exports: 'Artify'
    	},
    	Utils: {
    		deps: ['jQuery', 'Artify']
    	}
    },

    waitSeconds: 30
    
});