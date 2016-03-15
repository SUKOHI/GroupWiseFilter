<?php namespace Sukohi\GroupWiseFilter;

trait GroupWiseFilterTrait {

	private $_group_wise_group_by,
		$_group_wise_column;
	private $_group_wise_table_name = 'GROUP_TABLE';
	private $_group_wise_group_value = 'GROUP_VALUE';

	public function scopeGroupMax($query, $column, $group_by) {

		$this->groupWiseInit($column, $group_by);

		return $query->join(
			$this->getGroupSubQuery('max'),
			$this->getGroupJoin()
		);

	}

	public function scopeGroupMin($query, $column, $group_by) {

		$this->groupWiseInit($column, $group_by);

		return $query->join(
			$this->getGroupSubQuery('min'),
			$this->getGroupJoin()
		);

	}

	public function scopeOrderByGroup($query, $direction) {

		$group_table = $this->_group_wise_table_name;
		$group_value = $this->_group_wise_group_value;
		return $query->orderBy(\DB::raw($group_table .'.'. $group_value), $direction);

	}

	private function groupWiseInit($column, $group_by) {

		$this->_group_wise_column = $column;
		$this->_group_wise_group_by = $group_by;

	}

	private function getGroupSubQuery($mode) {

		$table = $this->getGroupTable();
		$group_mode = strtoupper($mode);
		$group_table = $this->_group_wise_table_name;
		$group_value = $this->_group_wise_group_value;
		return \DB::raw(
			'(SELECT '. $this->_group_wise_group_by .', '. $group_mode .'('. $this->_group_wise_column .') AS '. $group_value .' '.
			'FROM '. $table .' '.
			'GROUP BY '. $this->_group_wise_group_by .') AS '. $group_table
		);

	}

	private function getGroupTable() {

		return \DB::getTablePrefix() . $this->getTable();

	}

	private function getGroupJoin() {

		return function($join){

			$table = $this->getGroupTable();
			$group_table = $this->_group_wise_table_name;
			$group_value = $this->_group_wise_group_value;
			$join->on(
				\DB::raw($table .'.'. $this->_group_wise_group_by),
				'=',
				\DB::raw($group_table .'.'. $this->_group_wise_group_by)
			)->on(
				\DB::raw($table .'.'. $this->_group_wise_column),
				'=',
				\DB::raw($group_table .'.'. $group_value)
			);

		};

	}

}