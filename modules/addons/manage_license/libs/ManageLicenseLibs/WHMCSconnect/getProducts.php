<?php


namespace ML_Addon\WHMCSconnect;

use WHMCS\Database\Capsule as DB;


class getProducts {
	public $tblproductgroups;
	public $tblcurrencies;
	public $server;
	public $public;


	public function __construct() {
		$this->tblproductgroups = DB::table( 'tblproductgroups' )->get();
		$this->tblcurrencies    = DB::table( 'tblcurrencies' )->get();
//		 $this->pricing = DB::table( 'tblpricing' )->get() ;
 		$this->server     = DB::table( 'tblproducts' )->where( 'servertype', 'Manage_License' )->get();

	}

	public function getProducts() {
// 		return $this->server->get()->groupBy('tblproducts.gid');
		return $this->server->join( 'tblproductgroups', 'tblproductgroups.id', '=', 'tblproducts.gid' )->orderBy( 'tblproducts.gid' )->orderBy( 'tblproducts.order' )->get();
	}

	public function getProductGroup( int $id ) {
		foreach ( $this->tblproductgroups as $item ) {
			if ( $item->id == $id ) {
				return $item;
			}
		}


		return $this->tblproductgroups->whereid( $id )->first();
	}

	public function getServers( int $id ) {
		$getServers = [];
		foreach ( $this->server as $item ) {
			if ( $item->gid == $id ) {
				$getServers[] = $item;
			}
		}

		return $getServers;

	}

	public function getPGIds() {
		$getPGIds = [];

		foreach ( $this->server as $item ) {
			if ( ! in_array( $item->gid, $getPGIds ) ) {
				$getPGIds[] = $item->gid;
			}

		}

		if ( empty( $getPGIds ) ) {
			return false;
		}

		return $getPGIds;
	}


}
