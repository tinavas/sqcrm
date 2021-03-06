<?php 
// Copyright SQCRM. For licensing, reuse, modification and distribution see license.txt 
/**
* class ProspectLostToCompetitor
* @author Abhik Chakraborty
*/
class ProspectLostToCompetitor Extends CustomReport {

	/**
	* function to get the prospect lost to competitor by competitor name
	* @param string $where
	* @param integer $iduser
	* @param integer $date_filter_type
	* @param string $start_date
	* @param string $date_end
	* @return array
	*/
	public function get_prospect_lost_to_competitor($where = '',$iduser=0,$date_filter_type=15,$start_date='',$end_date='') {
		if ($where == '') {
			if ((int)$iduser == 0) {
				$iduser = $_SESSION["do_user"]->iduser ;
			}
			$where = '';
			$user_where = $this->get_report_where($iduser,'p','ptg') ;
			$date_where = $this->get_date_filter_where('p','expected_closing_date',$date_filter_type,$start_date='',$end_date='') ;
			$where = $user_where.$date_where ;
		}
		$qry = "
		select p.competitor_name,sum(p.amount) as amount
		from potentials p
		left join pot_to_grp_rel ptg on ptg.idpotentials = p.idpotentials
		where p.deleted = 0
		and p.sales_stage = 'Close Lost'
		and p.lost_reason = 'Lost To Competitor'
		$where
		group by p.competitor_name
		"; 
		$this->query($qry) ;
		$return_array = array() ;
		$grand_total = 0.0 ;
		if ($this->getNumRows() > 0) {
			while($this->next()) {
				$return_array[$this->competitor_name.' - '.FieldType30::display_value($this->amount)] = $this->amount;
				$grand_total += $this->amount ;
			}
		}
		return array("data"=>$return_array,"grand_total"=>$grand_total);
	}
	
	/**
	* function to get the detailed prospect lost to competitor data
	* @param string $where
	* @param integer $iduser
	* @param integer $date_filter_type
	* @param string $start_date
	* @param string $date_end
	* @return array
	*/
	public function get_detailed_prospect_lostto_competitor_data($where='',$iduser=0,$date_filter_type,$start_date='',$end_date='') {
		$do_potentials = new Potentials() ;
		$do_potentials->get_list_query() ;
		if ($where == '') {
			$user_where = $this->get_report_where($iduser,'potentials','pot_to_grp_rel') ;
			$date_where = $this->get_date_filter_where('potentials','expected_closing_date',$date_filter_type,$start_date='',$end_date='') ;
			$additonal_where = " AND
			`potentials`.`sales_stage` = 'Close Lost'
			AND `potentials`.`lost_reason` = 'Lost To Competitor'
			";
			$where = $user_where.$date_where.$additonal_where ;
		}
		$qry = $do_potentials->getSqlQuery() ;
		$qry .= $where ;
		$this->query($qry) ;
	}
}