<?php

/**
 * CrosswordTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CrosswordTable extends Doctrine_Table {

	/**
	 * Returns an instance of this class.
	 *
	 * @return object CrosswordTable
	 */
	public static function getInstance() {
		return Doctrine_Core::getTable('Crossword');
	}

	/**
	 * 
	 * 
	 * @param int $count
	 */
	public function getNewCrosswords($count = 10) {
		$query = $this->getQueryObject();

		return $query
				->where('is_activated = ?', true)
				->andWhere('is_public = ?', true)
				->addOrderBy('created_at DESC')
				->limit($count)
				->execute();
	}

	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $tagName
	 */
	public function getByTag(fzTag $tag) {
		return $tag->getCrosswords();
	}

	/**
	 *
	 * @param int $id
	 * @return Doctrine_Collection 
	 */
	public function getByIds($id) {

		if (!is_array($id) || count($id) <= 0) {
			throw new InvalidArgumentException('Crossowrd id must be array');
		}

		return $this->getQueryObject()
				->whereIn('id', $id)
				->execute();
	}

	/**
	 * 
	 * @param int $userId
	 */
	public function getUserCrosswordsQuery($userId) {

		if (empty($userId) || !is_numeric($userId)) {
			throw new InvalidArgumentException('User id is missing');
		}

		$query = $this->getQueryObject();
		return $query
				->where('user_id = ?', $userId);
	}

	/**
	 *
	 * @param type $maxCount
	 * @return type 
	 */
	public function getPopularCrosswords($maxCount = 10) {

		$crosswords = array();
		
		$answers = Doctrine::getTable('UserAnswer')
				->createQuery('ua')
				->select( 'ua.crossword_id, COUNT( ua.id ) as count_answers' )
				->leftJoin('ua.Crossword c')
				->where('c.is_public = ?', true)
				->groupBy('c.id')
				->orderBy('count_answers DESC')
				->limit($maxCount)
				->execute();

		$crosswordIds = array();
		if ( !empty( $answers ) && count( $answers ) > 0 ) {
			foreach ($answers as $answer) {
				$crosswordIds[] = $answer['crossword_id'];
			}
			return $this->getByIds( $crosswordIds );
		}
		
		return false;
	}
}