<?php


class AjaxController extends Controller
{

    public $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    public function outputJson($data){
        header('Content-Type: application/json');
        echo json_encode(["data"=>$data]);
    }

    public function actionGetTotals(){
        $data = [
          'income' => $this->getIncomeThisMonth(),
          'expenses' => $this->getExpenses(),
            'worth' => $this->getNetWorth(),
            'savings' => $this->getSavings()
        ];
        $this->outputJson($data);
    }

    public function actionGetAccountTotals(){
        $data = [
            'income' => $this->getReportIncome(),
            'expenses' => $this->getReportExpense(),
            'balance' => $this->getAccountBalance(),
            'savings' => $this->getReportSavings(),
        ];
        $this->outputJson($data);
    }

    public function actionGetInsightsTotals(){
        $data = [
            'income' => $this->getReportIncome(),
            'expenses' => $this->getReportExpense(),
            'average' => $this->getAvgExpense(),
            'savings' => $this->getReportSavings(),
        ];
        $this->outputJson($data);
    }

    private function getAvgExpense()
    {
        $filter = $this->getReportFilterByYear($_GET);
        return Utils::formatMoney(Queries::getAvgExpense($filter));
    }

    private function getReportIncome(){
        $filter = $this->getReportFilter($_GET);
        return Utils::formatMoney(Queries::getIncomeByFilter($filter));
    }

    private function getAccountBalance(){
        return Utils::formatMoney(Queries::getAccountBalance());
    }

    private function getReportFilter($settings){
        $filter= "";
        if(isset($settings['type'])){
            $type = $settings['type'];
            if($type == "month"){
                $nmonth = date("m", strtotime($settings['month']));
                $year = $settings['year'];
                $filter .= 'Month(trans_date)='. $nmonth.' AND Year(trans_date)='.$year;
            }else if($type=="range"){
                $filter .= 'trans_date between "'. $settings['startdate']
                    .'" AND "' . $settings['enddate']. '"';
            }
        }
        return $filter;
    }

    private function getReportFilterByYear($settings){
        $filter= "";
        if(isset($settings['type'])){
            $type = $settings['type'];
            if($type == "month"){
                $year = $settings['year'];
                $filter .= 'Year(trans_date)='.$year;
            }else if($type=="range"){
                $currentYear = date("Y", strtotime($settings['startdate']));
                $filter .= 'Year(trans_date)='.$currentYear;
            }
        }
        return $filter;
    }

    private function getIncomeThisMonth(){
        $month = date('m');
        return Utils::formatMoney(Queries::getIncomeByGivenMonth($month));
    }

    private function getExpenses(){
        $month = date('m');
        return Utils::formatMoney(Queries::getExpenses($month));
    }

    private function getReportExpense(){
        $filter = $this->getReportFilter($_GET);
        return Utils::formatMoney(Queries::getExpenseByFilter($filter));
    }

    private function getSavings(){
        $month = date('m');
        return Utils::formatMoney(Queries::getSavings($month));
    }

    private function getReportSavings(){
        $filter = $this->getReportFilter($_GET);
        return Utils::formatMoney(Queries::getSavingsByFilter($filter));
    }

    private function getNetWorth(){
        return Utils::formatMoney(Queries::getNetWorth());
    }

    public function actionChart($name){
        if($name == "income_expenditure"){

        }
    }

    public function actionGetTransactionsTable(){
        $criteria = new CDbCriteria();
        $criteria->limit = 300;
        $criteria->order = 'trans_date DESC';
        $transactions = Transaction::model()->findAll($criteria);
        echo $this->renderPartial('dashboard_transactions',
            ['transactions'=>$transactions]);
    }

    public function actionGetTransactionsTableWithFilters(){
        $criteria = new CDbCriteria();
        $criteria->condition = $this->getReportFilter($_GET);
        $criteria->order = 'trans_date DESC';
        $transactions = Transaction::model()->findAll($criteria);
        echo $this->renderPartial('dashboard_transactions',
            ['transactions'=>$transactions]);
    }

    public function actionGetExpenseListing(){
        echo $this->renderPartial('list_expenses');
    }

    public function actionGetIncomeExpenditureChartData(){
        echo json_encode(
            ['data' => $this->getIncomeExpenditure()]
        );
    }

    public function actionGetReportIEChartData(){
        echo json_encode(
            ['data' => $this->getReportIncomeExpenditure($_GET)]
        );
    }

    public function actionGetTopExpenses(){
        echo json_encode([
           'data' => $this->getTopExpenses()
        ]);
    }

    public function actionGetAllExpenses(){
        echo json_encode([
            'data' => $this->getAllExpenses($_GET)
        ]);
    }

    public function actionGetCalendarTransactions(){
        $dates = $this->convertTransactionsToCalendar();
        echo json_encode(
            [
                'data'=>$dates
            ]
        );
    }

    public function actionSaveTransaction(){
        $model = new Transaction();
        $model->trans_date = $_POST['transDate'];
        $model->amount = str_replace( ',', '', $_POST['amount']); // replace thousands comma
        $model->category = $_POST['category'];
        $model->description = $_POST['description'];
        $model->account_id = 1;
        $model->type = $_POST['transType'];
        $model->save();
    }

    public function actionUpdateTransaction(){
        $model = Transaction::model()->findByPk($_POST['transId']);
        $model->trans_date = $_POST['transDate'];
        $model->amount = str_replace( ',', '', $_POST['amount']); // replace thousands comma
        $model->category = $_POST['category'];
        $model->description = $_POST['description'];
        $model->account_id = 1;
        $model->type = $_POST['transType'];
        $model->update();
    }

    public function actionSaveUserCategory(){
        $model = new UserCategories();
        $model->name = $_POST['usercategory'];
        $model->userid = 1;
        $model->save();
    }

    public function actionDeleteTransaction(){
        $id = $_POST['id'];
        Transaction::model()->findByPk($id)->delete();
        echo 'done';
    }

    private function convertTransactionsToCalendar(){
        $transactions = Transaction::model()->findAll();
        $calendar_dates = [];
        foreach ($transactions as $transaction){
            $calendar_dates[] = [
                'title' => $transaction->description,
                'description' => Utils::formatMoney($transaction->amount)
                    . " (" . $transaction->category. ")",
                'start' => $transaction->trans_date,
                'className' => $this->getCalendarItemClassName($transaction)
            ];
        }
        return $calendar_dates;
    }

    private function getCalendarItemClassName($transaction){
        $type = $transaction->type;
        if( $type == "expense"){
            return "fc-event-danger";
        }
        return "fc-event-success";
    }


    private function getIncomeExpenditure(){
        $labels = $this->months;
        $incomeData = Queries::getIncomeByMonth();
        $income_data = $this->convert_to_months_dataset('date','total', $incomeData);
        $expenseData = Queries::getExpensesByMonth();
        $expense_data  = $this->convert_to_months_dataset('date','total', $expenseData);
        return [
            'income' => $income_data,
            'expense' => $expense_data,
            'labels' => $labels
        ];
    }

    private function getReportIncomeExpenditure($settings){
        $filter = $this->getReportFilterByYear($settings);
        $labels = $this->months;
        $incomeData = Queries::getIncomeByMonthWithFilter($filter);
        $income_data = $this->convert_to_months_dataset('date','total', $incomeData);
        $expenseData = Queries::getExpensesByMonthWithFilter($filter);
        $expense_data  = $this->convert_to_months_dataset('date','total', $expenseData);
        return [
            'income' => $income_data,
            'expense' => $expense_data,
            'labels' => $labels
        ];
    }

    public function actionGetUpdateCategoriesList(){
        echo CHtml::dropDownList('category', '', Categories::model()->getListing(),
                array('class' => 'form-control',
                    'id' => 'category', 'empty' => '--Select category--',
                    'style' => 'height:50px;width:100%'));
    }

    public function actionTransactionDetails(){
        $id = $_GET['id'];
        $model = Transaction::model()->findByPk($id);
        echo json_encode(['data'=> $model->getAsJSONObject()]);
    }

    public function actionTest(){
        echo Queries::getAccountBalance();
    }

    private function getTopExpenses(){
        $data = Queries::getTopExpensesByYear();
        $labels = $this->convert_data_to_pie_dataset('category', $data);
        $dataset = $this->convert_data_to_pie_dataset('total',$data);
        return [
            'labels' => $labels,
            'dataset' => $dataset,
        ];
    }

    private function getAllExpenses($settings){

        $data = Queries::getAllExpensesByYear($this->getReportFilter($settings));
        $labels = $this->convert_data_to_pie_dataset('category', $data);
        $dataset = $this->convert_data_to_pie_dataset('total',$data);
        return [
            'labels' => $labels,
            'dataset' => $dataset,
            'colors' => $this->getHexColors(count($labels)),
            'percentages' => $this->convert_data_to_pie_dataset('percentage',$data)
        ];
    }

    private function convert_to_months_dataset($key, $value, $source){
        $income_data = [];
        $match = false;
        for($i=0; $i<= 11; $i++){
            $match = false;
            foreach($source as $query){
                if($query[$key] == ($i+1)){
                    $income_data[] = $query[$value];
                    $match = true;
                    break;
                }
            }
            if(!$match){
                $income_data[] = 0;
            }
        }
        return $income_data;
    }

    private function convert_data_to_pie_dataset($name, $source){
        $dataset = [];
        foreach ($source as $row){
            $dataset[] = $row[$name];
        }
        return $dataset;
    }




}