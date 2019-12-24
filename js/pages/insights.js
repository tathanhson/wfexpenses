var InsightsPage = (function() {

    var inTile = $('#in-tile');
    var exTile = $('#ex-tile');
    var svTile = $('#sv-tile');
    var avTile = $('#av-tile');
    var lsExpensesLay = $('#list-expenses');
    var transLay = $('#trans-layout');

    function loadTiles(response){
        PDMApp.setElContent(inTile,response.income);
        PDMApp.setElContent(exTile,response.expenses);
        PDMApp.setElContent(svTile,response.savings);
        PDMApp.setElContent(avTile,response.average);
    }

    function loadPageData(){
        PDMApp.addLoaders();
        $.getJSON('/ajax/getaccounttotals',function(response){
            loadTiles(response.data);
        });
        $.getJSON('/ajax/GetIncomeExpenditureChartData',function(response){
            PDMCharts.loadDashboardIEChart('incomevsexpense', response.data);
        });
        $.getJSON('/ajax/GetAllExpenses',function(response){
            PDMCharts.loadMultiCatPieChart('pie-cats',response.data);
        });
        $.get('/ajax/GetTransactionsTable',function(data){
            transLay.empty().append(data);
        });
    }

    $(document).on(PDMApp.cdpOnChangeEventName(),function(){
        var settings = PDMApp.getCdpSettings();
        console.log(settings.type)
       // loadPageData();
    });

    return {
        loadPageData : loadPageData
    }

})();

InsightsPage.loadPageData();
