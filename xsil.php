<?php


$stack = array(
	array(
		'id' => 1,
		'pid' => 0
	),

	array(
		'id' => 2,
		'pid' => 1
	),

	array(
		'id' => 3,
		'pid' => 1
	),

	array(
		'id' => 4,
		'pid' => 0
	)
);

function hasChild($stack, $id) {
	foreach($stack as $row) {
		if ($row['pid'] == $id) {
			return true;
		}
	}
	return false;
}

function buildTree($stack, $pid, &$nodes) {
	foreach($stack as $row) {
		if ($row['pid'] == $pid) {
			$node = array(
				'id' => $row['id'],
				'leaf' => FALSE,
				'expanded' => TRUE,
				'children' => array()
			);
			
			if (hasChild($stack, $row['id'])) {
				buildTree($stack, $row['id'], $node['children']);
			} else {
				unset($node['children']);
				$node['expanded'] = FALSE;
				$node['leaf'] = TRUE;
			}

			$nodes[] = $node;
		}
	}
}

$nodes = [];
buildTree($stack, 0, $nodes);
print(json_encode($nodes));

?>
