<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_Model extends CI_Model {


	/**create_order function
    // @param : order_entity[] - contains the emailid
    // @param : order_item_entity[] - contains values name,price,quantity
    // function inserts data to  Orders_Entity and Order_Items_Entity  
    
    **/
	public function create_order($order_entity,$order_item_entity){

		//extracts all values from $order_entity[]
		foreach(array_keys($order_entity) as $i)
			$order_entity[$i]=$this->db->escape($order_entity[$i]);

		
		//extracts all values from $order_item_entity[]
		foreach(array_keys($order_item_entity) as $i)
			$order_item_entity[$i]=$this->db->escape($order_item_entity[$i]);
		
		
		//implode function separates each value with ',' character and stores to variable $values
		//$values contains values from both $order_entity and $order_item_entity
		$values=implode(',',$order_entity).','.implode(',',$order_item_entity);


		//call to stored procedure create_order_sp stored in the database
		//create_order_sp inserts data to  Orders_Entity and Order_Items_Entity
		if($this->db->query("call create_order_sp({$values})")){
			
			$response=array('Msg'=>'Successfully created order','Status'=>'created');
		}
		else
			$response=array('Msg'=>'Database error','Status'=>'Error');

		//json_encode function converts php array to json format
		//returns the response message in json format
		return json_encode($response);
		
	}





	/**update_order_orderItems function
    // @param : order_entity[] - contains the emailid
    // @param : order_item_entity[] - contains values name,price,quantity
    // function updates data in  Orders_Entity and Order_Items_Entity  
    
    **/

	public function update_order_orderItems($order_entity,$order_item_entity){

		
		//extracts all values from $order_entity[]
		foreach(array_keys($order_entity) as $i)
			$order_entity[$i]=$this->db->escape($order_entity[$i]);


		//extracts all values from $order_item_entity[]
		foreach(array_keys($order_item_entity) as $i)
			$order_item_entity[$i]=$this->db->escape($order_item_entity[$i]);


		//implode function separates each value with ',' character and stores to variable $values
		//$values contains values from both $order_entity and $order_item_entity
		$values=implode(',',$order_entity).','.implode(',',$order_item_entity);


		//call to stored procedure update_order_orderItem_sp stored in the database
		//update_order_orderItem_sp updates data in  Orders_Entity and Order_Items_Entity
		if($this->db->query("call update_order_orderItem_sp({$values})")){
			$response=array('Msg'=>'Successfully updated your order','Status'=>'updated');
		}
		else
			$response=array('Msg'=>'Database error','Status'=>'Error');



		//json_encode function converts php array to json format
		//returns the response message in json format
		return json_encode($response);
	}



	/**cancel_order function
    // @param : order_id - contains the unique order_id
    // function updates status attribute of the entity Orders_Entity and sets value as 'cancelled'
    
    **/

	public function cancel_order($order_id){


		//call to stored procedure cancel_order stored in the database
		//cancel_order takes the order_id and sets the status attribute value as 'cancelled'
		if($this->db->query("call cancel_order(?)",array('order_id'=>$order_id))){

			$response=array('Msg'=>'Your order has been cancelled','Status'=>'cancelled');
		}
		else
			$response=array('Msg'=>'Database error','Status'=>'Error');

		//json_encode function converts php array to json format
		//returns the response message in json format
		return json_encode($response);
	}

	




	/**add_Payment function
    // @param : order_id - contains the unique order_id
    // function updates status attribute of the entity Orders_Entity and sets value as 'processed'
    
    **/
    public function add_Payment($order_id){



    	//call to stored procedure add_Payment stored in the database
		//add_Payment takes the order_id and sets the status attribute value as 'processed'
		if($this->db->query("call add_Payment(?)",array('order_id'=>$order_id))){
			$response=array('Msg'=>'Payment successfull','Status'=>'Processed');
		}
		else
			$response=array('Msg'=>'Database error','Status'=>'Error');


		//json_encode function converts php array to json format
		//returns the response message in json format
		return json_encode($response);
	
	}



	/**get_Order_By_Id function
    // @param : order_id - contains the unique order_id
    // function fetches and returns the order details corresponding to the order_id from  Orders_Entity 
    // and Order_Items_Entity  
    
    **/
	public function get_Order_By_Id($order_id){

		//selects 
		//emailid,status,order_created_at,order_updated_at,name,price,quantity,order_item_created_at and order_item_updated_at details 
		//from database joining orders_entity and order_items_entity table
		//based on foreign_key order_id 
		//where order_id matches only with the id passed to the function

		$query=$this->db->select('Orders_Entity.email_id,Orders_Entity.status,Orders_Entity.created_at as order_created_at,Orders_Entity.updated_at as order_updated_at,Order_Items_entity.name,Order_Items_entity.price,Order_Items_entity.quantity,Order_Items_entity.created_at as order_item_created_at,Order_Items_entity.updated_at as order_item_updated_at')
			
						->from('Orders_Entity')
						->join('Order_Items_Entity','Orders_Entity.id=Order_Items_Entity.order_id')
						->where('Orders_Entity.id',$order_id)
						->get();

			if($query){
		

		//fetches data from resultset using result() function and stores to $row[]
			foreach ($query->result() as $row)				
			{
   			    $order['emailid'] = $row->email_id;
        		$order['order_status'] = $row->status;
        		$order['order_created_at'] = $row->order_created_at;
        		$order['order_updated_at'] = $row->order_updated_at;
        		$order['item_name'] = $row->name;
        		$order['item_price'] = $row->price;
        		$order['quantity']= $row->quantity;
        		$order['order_item_created_at']= $row->order_item_created_at;
        		$order['order_item_updated_at']= $row->order_item_updated_at;
			}
			
			//response will have the fetched data array encoded in json format
			$response=json_encode($order);
			

		}
		else
			$response=json_encode(array('Msg'=>'Database error','Status'=>'Error'));

		return $response;
	}





	/**get_User_Orders function
    // @param : user_id - contains the unique email_id of user
    // function fetches and returns the order details corresponding to the user_id from  Orders_Entity 
    // and Order_Items_Entity  
    
    **/

	public function get_User_Orders($user_id){


		//selects 
		//status,order_created_at,order_updated_at,name,price,quantity,order_item_created_at and order_item_updated_at details 
		//from database joining orders_entity and order_items_entity table
		//based on foreign_key order_id 
		//where email_id matches only with the user_id passed to the function

		$query=$this->db->select('Orders_Entity.status,Orders_Entity.created_at as order_created_at,Orders_Entity.updated_at as order_updated_at,Order_Items_entity.name,Order_Items_entity.price,Order_Items_entity.quantity,Order_Items_entity.created_at as order_item_created_at,Order_Items_entity.updated_at as order_item_updated_at')
			
						->from('Orders_Entity')
						->join('Order_Items_Entity','Orders_Entity.id=Order_Items_Entity.order_id')
						->where('Orders_Entity.email_id',$user_id)
						//->where('Orders_Entity.id',$user_id)
						->get();

	
		if($query){
			
			//list_of_orders will have each order made by user in different array index
			
			$list_of_orders = array();
			foreach ($query->result_array() as $row)
			{
   				//each time loop executes the consecutive rows gets 
   				//stored to consecutive array index of list_of_orders[]
   				
   				$list_of_orders[] = $row;

			}
			
			//response will have the fetched list_of_orders array encoded in json format

			$response=json_encode($list_of_orders);
		}
		else
			$response=json_encode(array('Msg'=>'Database error','Status'=>'Error'));
		return $response;

		}



	/**list_Orders_Made_Today function
    // function fetches and returns the 
    //list of orders and order_attributes made on current_date 
    //from  Orders_Entity and Order_Items_Entity  
    
    **/
	public function list_Orders_Made_Today(){


		//selects 
		//emailid,status,order_created_at,order_updated_at,name,price,quantity,order_item_created_at and order_item_updated_at details 
		//from database joining orders_entity and order_items_entity table
		//based on foreign_key order_id 
		//where order_created_date matches  with the current_date

		$query=$this->db->select('Orders_Entity.email_id,Orders_Entity.status,Orders_Entity.created_at as order_created_at,Orders_Entity.updated_at as order_updated_at,Order_Items_entity.name,Order_Items_entity.price,Order_Items_entity.quantity,Order_Items_entity.created_at as order_item_created_at,Order_Items_entity.updated_at as order_item_updated_at')
			
						->from('Orders_Entity')
						->join('Order_Items_Entity','Orders_Entity.id=Order_Items_Entity.order_id')
						
						->where('date(Orders_Entity.created_at)',date('2017-07-21'))
						->get();
			if($query)
				{

					$list_of_orders = array();
					foreach ($query->result_array() as $row)
		   			{	$list_of_orders[] = $row;
		   				
		   			}
		   			$response=json_encode($list_of_orders);
				}
				else
			$response=json_encode(array('Msg'=>'Database error','Status'=>'Error'));
			//response will have the fetched list_of_orders array encoded in json format

		return $response;

	}

	}
	

	?>