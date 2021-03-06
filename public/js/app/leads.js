function Leads() {
    var self = this;

    var limit = 20;
    var offset = 0;

    self.isError = ko.observable(false);
    self.errors = ko.observableArray([]);
    self.isDeleted = ko.observable(false);
    self.selectedRequest = ko.observable();

    self.list = ko.observableArray([]);
    self.pageQty = ko.observable(0);
    self.currentPage = ko.observable(0);
    self.total = ko.observable(0);

    self.page = function (page) {
        offset = limit * page;
        updateList();
    };

    self.view = function (item) {
        self.selectedRequest(item);
        $('#request-modal').modal();
    };

    self.remove = function (request) {
        del('/api/v1/leads/' + request.id)
            .done(function () {
                self.isDeleted(true);
                updateList();
            })
            .fail(function () {
                self.isError(true);
                self.errors(response.responseJSON);
            });
    };

    self.objectToArray = objectToArray;

    function load(limit, offset) {
        return get('/api/v1/leads', {
            limit: limit,
            offset: offset
        });
    }

    function updateList() {
        load(limit, offset)
            .done(function (response, status, xhr) {
                self.list(response);
                self.currentPage(parseInt(xhr.getResponseHeader(HEADER_PAGINATION_PAGE)));
                self.total(parseInt(xhr.getResponseHeader(HEADER_PAGINATION_TOTAL)));
                self.pageQty(parseInt(xhr.getResponseHeader(HEADER_PAGINATION_PAGES)));
            })
            .fail(logout);
    }

    updateList();
}