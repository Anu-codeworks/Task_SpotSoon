<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API extends CI_Controller {

    //constructor function loads the model class Order_Model
	public function __construct() {
               parent::__construct();
               $this->load->model('Order_Model');
 
    }    
       
    /**create_order function
    // function takes no parameters
    // function is created to add new order to the database.
    // the $order[] and $item[] array fetches the email_id,name,price,quantity key values from post request
    // the arrays are passed as parameter to the model class function create_order() 
    **/
    public function create_order(){
        $order['email_id']=$this->input->post('email_id');
			
		$item['name']=$this->input->post('name');
		$item['price']=$this->input->post('price');
		$item['quantity']=$this->input->post('quantity');
		
		$response=$this->Order_Model->create_order($order,$item);
		echo $response;
          
    }


    /**update_order_orderItems function
    // function takes no parameters
    // function is created to update order and order attributes in the database.
    // the $order[] and $item[] array fetches the email_id,name,price,quantity key values from post request
    // the arrays are passed as parameter to the model class function update_order_orderItems() 
    **/

    public function update_order_orderItems(){
    	$order['id']=$this->input->post('id');
    	$order['email_id']=$this->input->post('email_id');
		$order['status']=$this->input->post('status');
		$item['name']=$this->input->post('name');
		$item['price']=$this->input->post('price');
		$item['quantity']=$this->input->post('quantity');
		$response=$this->Order_Model->update_order_orderItems($order,$item);
		echo $response;
    }

    /**cancel_order function
    // function takes no parameters
    // function is created to update status of order as 'cancelled' in the database.
    // the $order_id fetches the id key value from post request
    // the id is passed as parameter to the model class function cancel_order() 
    **/
    public function cancel_order(){
    	$order_id=$this->input->post('id');
    	$response=$this->Order_Model->cancel_order($order_id);
    	echo $response;

    }

    /**add_Payment function
    // function takes no parameters
    // function uses the order_id to complete the payment
    // in this API the function is only made to update the status of order as 'Processed'
    // the $order_id fetches the id key value from post request
    // the id is passed as parameter to the model class function add_Payment() 
    **/
    public function add_Payment(){
    	$order_id=$this->input->post('id');
    	$response=$this->Order_Model->add_Payment($order_id);
    	echo $response;
    }

    /**get_Order_By_Id function
    // function takes no parameters
    // function is created to fetch the order corresponding to a particular order_id from the database.
    // the $order_id fetches the id key value from get request
    // the id is passed as parameter to the model class function get_Order_By_Id() 
    **/
    public function get_Order_By_Id()
    {
    	$order_id=$this->input->get('id');
    	$response=$this->Order_Model->get_Order_By_Id($order_id);
    	echo $response;

    }



    /**get_User_Orders function
    // function takes no parameters
    // function is created to fetch all orders made by specific user using emailid from the database.
    // the $user_id fetches the email_id key value from get request
    // the user_id is passed as parameter to the model class function get_User_Orders() 
    **/
    public function get_User_Orders(){
    	$user_id=$this->input->get('email_id');
    	$response=$this->Order_Model->get_User_Orders($user_id);
    	echo $response;
    }

    /**list_Orders_Made_Today function
    // function takes no parameters
    // function is created to fetch all orders made on current date from the database.
    // function calls the model class function list_Orders_Made_Today() to fetch the data 
    **/
    public function list_Orders_Made_Today(){
    	$response=$this->Order_Model->list_Orders_Made_Today();
    	echo  $response;
    }
}
    ?>