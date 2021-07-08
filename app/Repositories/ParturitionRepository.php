<?php

namespace App\Repositories;

use \Illuminate\Support\Facades\DB;
use \Illuminate\Database\QueryException;

use App\Repositories\Base\BaseRepository;

use App\Models\Services\Parturition;

class ParturitionRepository extends BaseRepository
{
	public function __construct()
	{
		$this->setInitModel(new Parturition);
	}

	/*
		Create dan Update
	*/
	public function save(array $partusData = [])
	{
		try {
			$partus = $this->getModel();
			$partus->fill($partusData);
			$partus->raw_service_fee = $partusData['service_fee'];
			$partus->raw_discount = $partusData['discount'];
			$partus->save();

			$this->setModel($partus);

			$this->setSuccess('Sukses menyimpan data partus.');
		} catch (QueryException $qe) {
			$error = $qe->getMessage();
			$this->setError('Gagal menyimpan data partus.', $error);
		}

		return $this->getModel();
	}

	public function delete()
	{
		try {
			$partus = $this->getModel();
			$partus->delete();

			$this->destroyModel();

			$this->setSuccess('Sukses menghapus data partus.');
		} catch (QueryException $qe) {
			$error = $qe->getMessage();
			$this->setError('Gagal menghapus data partus.', $error);
		}

		return $this->returnResponse();
	}
}