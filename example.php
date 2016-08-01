function hasChild($stack, $id) {
		foreach($stack as $row) {
			if ($row['tnbc_nbc_parent_id'] == $id) {
				return true;
			}
		}
		return false;
	}

	function buildTree($stack, $pid, &$nodes) {
		foreach($stack as $row) {
			if ($row['tnbc_nbc_parent_id'] == $pid) {
				if(!empty($row['tnbc_nbc_name'])){ $nbc_name = $row['tnbc_nbc_name']; }else{ $nbc_name = $row['tnbc_nbc_no']; }
				$node = array(
					'id' => $row['tnbc_nbc_id'],
					'task' => $nbc_name,
					'tnbc_nbc_no' => $row['tnbc_nbc_no'],
					'tnbc_nbc_id' => $row['tnbc_nbc_id'],
					'tnbc_nbc_order' => $row['tnbc_nbc_order'],
					'tnbc_nbc_name' => $row['tnbc_nbc_name'],
					'iconCls' => 'task-folder',
					'leaf' => FALSE,
					'expanded' => TRUE,
					'children' => array()
				);
				
				if ($this->hasChild($stack, $row['tnbc_nbc_id']) == true) {
					$this->buildTree($stack, $row['tnbc_nbc_id'], $node['children']);
				} else {
					unset($node['children']);
					unset($node['expanded']);
					// $node['expanded'] = FALSE;
					$node['leaf'] = TRUE;
				}
				$nodes[] = $node;
			}
		}
	}

	function get_data_grid(){
		$params = array(
			'table' => 'trx_nbwo_boq_category',
			'where' => array(),
			'order_by' => array(
				'field' => 'tnbc_nbc_order',
				'sort' => 'ASC'
			)
		);
		$res = $this->get_db->get_data($params)->result_array();
		$nodes = [];
		$this->buildTree($res, 0, $nodes);
		print(json_encode($nodes));
	}
