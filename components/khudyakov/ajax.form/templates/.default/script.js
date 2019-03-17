;
function AjaxFormComponent(params)
{
    this.ajaxUrl = params.ajaxUrl || '';
    this.signedParamsString = params.signedParamsString || '';
    this.siteId = params.siteId || '';
    this.formId = params.formId || '';

    this.$successWrapper = $('#'+this.formId+'-success-wrapper');
    this.$errorWrapper = $('#'+this.formId+'-error-wrapper');

    var self = this;

    this.init = function()
    {
        $('#'+self.formId).on('submit', function(event) {
            event.preventDefault();
            self.sendRequest();
        });
    };

    this.getData = function()
    {

        let data = {};

        $.each($('#'+self.formId).serializeArray(), function() {
            data[this.name] = this.value;
        });

        data.site_id = this.siteId;
        data.sessid = BX.bitrix_sessid();
        data.signedParamsString = this.signedParamsString;

        return data;
    };

    this.sendRequest = function()
    {
        self.$errorWrapper.addClass('hidden');
        self.$successWrapper.addClass('hidden');

        BX.ajax({
            method: 'POST',
            dataType: 'json',
            url: self.ajaxUrl,
            data: self.getData(),
            onsuccess: BX.delegate(function(result) {

                if (result.error) {
                    self.$errorWrapper.text(result.error);
                    self.$errorWrapper.toggleClass('hidden');
                } else if (result.success) {
                    self.$successWrapper.text(result.success);
                    self.$successWrapper.toggleClass('hidden');
                }

            }, self),
            onfailure: BX.delegate(function() {
                console.log(result);
            }, self)
        });
    };

    self.init();
}