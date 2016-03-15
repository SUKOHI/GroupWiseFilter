<?php namespace Sukohi\GroupWiseFilter;

trait GroupWiseFilterTrait {

	private $_group_wise_group_by,
			$_group_wise_column;

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

	private function groupWiseInit($column, $group_by) {

		$this->_group_wise_column = $column;
		$this->_group_wise_group_by = $group_by;

	}

	private function getGroupSubQuery($mode) {

		$table = $this->getGroupTable();
		$group_mode = strtoupper($mode);
		return \DB::raw(
			'(SELECT '. $this->_group_wise_group_by .', '. $group_mode .'('. $this->_group_wise_column .') AS GROUP_VALUE '.
			'FROM '. $table .' '.
			'GROUP BY '. $this->_group_wise_group_by .') AS GROUP_TABLE'
		);

	}

	private function getGroupTable() {

		return \DB::getTablePrefix() . $this->getTable();

	}

	private function getGroupJoin() {

		return function($join){

			$table = $this->getGroupTable();
			$join->on(
					\DB::raw($table .'.'. $this->_group_wise_group_by),
					'=',
					\DB::raw('GROUP_TABLE.'. $this->_group_wise_group_by)
				)
				->on(
					\DB::raw($table .'.'. $this->_group_wise_column),
					'=',
					\DB::raw('GROUP_TABLE.GROUP_VALUE')
				);

		};

	}

}