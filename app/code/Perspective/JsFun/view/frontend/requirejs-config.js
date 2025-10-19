var config = {
    "map": {
        "*": {
            "fadeInElement": "Perspective_JsFun/js/fade-in-element",
            "Magento_Review/js/submit-review": "Perspective_JsFun/js/submit-review"
        }
    },

    "paths": {
        "vue": [
            "https://cdn.jsdelivr.net/npm/vue@2/dist/vue",
            "Perspective_JsFun/js/vue"
        ]
    },

    "shim": {
        "Perspective_JsFun/js/jquery-log": ["jquery"]
    },

    "deps": ["Perspective_JsFun/js/every-page"],

    "config": {
        "mixins": {
            "Magento_Ui/js/view/messages": {
                "Perspective_JsFun/js/messages-mixin": true
            }
        }
    }
};

console.log("TestTestTestTest")
