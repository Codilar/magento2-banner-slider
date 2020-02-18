define([
    'Magento_Ui/js/form/element/image-uploader',
    'uiRegistry'
], function (Element, uiRegistry) {
    'use strict';

    return Element.extend({
        attachDependListeners: function () {
            var self = this;
            var depends = self['depends'] ? Object.values(self['depends']) : [];
            depends.forEach(function (depend) {
                var field = uiRegistry.get('index = ' + depend.field);
                if (field) {
                    self.dependsFieldMap.push({
                        field: field,
                        value: depend.value
                    });
                    field.on('update', self.validateDepend.bind(self));
                }
            });
        },

        validateDepend: function () {
            var valid = this.dependsFieldMap.every(function (dependField) {
                return dependField.field.value() == dependField.value;
            });
            if (valid) {
                this.show();
            } else {
                this.hide();
            }
        },

        initialize: function () {
            this._super();
            this.dependsFieldMap = [];
            setTimeout(function () {
                this.attachDependListeners();
                this.validateDepend();
            }.bind(this));
        }
    });
});