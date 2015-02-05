<?php
App::uses('AppController', 'Controller');
/**
 * Orders Controller
 *
 * @property Order $Order
 */
class OrdersController extends AppController {
	
	
	
	function beforefilter() {
		parent::beforefilter();
		$admin = $this->Session->read("admin");
		$this->checklogin();
	}
	
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->paginate = (array("order"=>"Order.created DESC,Order.id DESC"));
		/* code to perform search functionality */
		if(isset($this->data) && !empty($this->data['Order']['searchval'])){
			$this->Session->write('searchval',$this->data['Order']['searchval']);
			$this->conditions	= array("OR"=>array("Order.paymentref like"=>"%".$this->data['Order']['searchval']."%"));
		}
		
		if(isset($this->params['named']['page'])){
			
			if($this->Session->read('searchval')){
				$this->conditions	= array("OR"=>array("Order.paymentref like"=>"%".$this->Session->read('searchval')."%"));
				$this->data['Order']['searchval'] = $this->Session->read('searchval');
			}
		}elseif(empty($this->conditions)){
			$this->Session->delete('searchval');
		}
		/* end of code to perform search functionality */
		$this->conditions = array_merge($this->conditions,array("Order.order_id "=>0));
		$this->Order->recursive = 1;
		$this->set('orders', $this->paginate($this->conditions));
	}
	
	function admin_viewtransaction($id = NULL) {
		$order = $this->Order->find("first",array("conditions"=>array("Order.id"=>$id)));
		/* code to perform search functionality */
		if(isset($this->data) && !empty($this->data['Order']['searchval'])){
			$this->Session->write('searchval',$this->data['Order']['searchval']);
			$this->conditions	= array("Order.paymentref like"=>"%".$this->data['Order']['searchval']."%");
		} 
		
		if(isset($this->params['named']['page'])){
			
			if($this->Session->read('searchval')){
				$this->conditions	= array("OR"=>array("Order.paymentref like"=>"%".$this->Session->read('searchval')."%"));
				$this->data['Order']['searchval'] = $this->Session->read('searchval');
			}
		}elseif(empty($this->conditions)){
			$this->Session->delete('searchval');
		}
		/* end of code to perform search functionality */
		if (!empty($order)) {
			$this->conditions = array_merge($this->conditions,array("OR"=>array("Order.id"=>$id,"Order.order_id"=>$id)));
			$orders = $this->Order->find("all",array("conditions"=>$this->conditions,"order"=>"Order.order_id ASC"));
			$this->set(compact("orders"));
		} else {
			$this->Session->setFlash("Invalid transaction.");
			$this->redirect(array("action"=>"index"));
		}
	}

}
