<?php

require_once "BaseService.php";

/**
 *  Plot related service
 */
class PlotsService extends BaseService {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->tablename = "plots";
	}

	/**
	 * Returns all the rows from the table.
	 *
	 * @param int $project_id
	 * @param int $tsa
	 * @return array
	 */
	public function getAllPlots($project_id, $tsa) {
		$sql =<<<DOQ
			SELECT plots.project_id, plots.tsa, plots.plotid,
				 x, y, lat, lng, dist_year, sequence_order
			FROM plots
			WHERE plots.project_id=$project_id
			AND plots.tsa=$tsa
			ORDER BY plotid, sequence_order
DOQ;

		$this->connect();
		$stmt = mysqli_prepare($this->connection, $sql);
		$this->throwExceptionOnError();

		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();

		$rows = array();

		mysqli_stmt_bind_result($stmt,
														$row->project_id,
														$row->tsa,
														$row->plotid,
														$row->x,
														$row->y,
														$row->lat,
														$row->lng,
                            $row->dist_year,
                            $row->sequence_order);

	  while (mysqli_stmt_fetch($stmt)) {
	  	$rows[] = $row;
	    $row = new stdClass();

			mysqli_stmt_bind_result($stmt,
														$row->project_id,
														$row->tsa,
														$row->plotid,
														$row->x,
														$row->y,
														$row->lat,
														$row->lng,
                            $row->dist_year,
                            $row->sequence_order);

    }

		mysqli_stmt_free_result($stmt);
	  mysqli_close($this->connection);

	  return $rows;
	}

}


