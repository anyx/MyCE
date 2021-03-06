<?php

/**
 * UserAnswerTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class UserAnswerTable extends Doctrine_Table {

    /**
     * Returns an instance of this class.
     *
     * @return object UserAnswerTable
     */
    public static function getInstance() {
        return Doctrine_Core::getTable('UserAnswer');
    }

    /**
     * 
     * Enter description here ...
     * @param int $user_id
     * @param int $crossword_id
     * @throws InvalidArgumentException
     */
    public function getUserAnswer($user_id, $crossword_id) {

        if (empty($user_id) || !is_numeric($user_id)) {
            throw new InvalidArgumentException('User id is missing');
        }

        if (empty($crossword_id) || !is_numeric($crossword_id)) {
            throw new InvalidArgumentException('Crossword id is missing');
        }

        $query = $this->getQueryObject();

        return $query
                ->where('crossword_id = ?', $crossword_id)
                ->andWhere('user_id = ?', $user_id)
                ->fetchOne();
    }

    /**
     * 
     * Enter description here ...
     * @param int $crossword_id
     */
    public function getCrosswordAnswers($crossword_id) {

        if (empty($crossword_id)) {
            throw new InvalidArgumentException('Crossword id is missing');
        }

        $query = $this->getQueryObject();

        $answers = $query
                ->whereIn('crossword_id', $crossword_id)
                ->execute();

        if ($answers->count() <= 0) {
            return false;
        }

        $result = array();

        foreach ($answers as $answer) {

            if (!array_key_exists($answer->getCrosswordId(), $result)) {
                $result[$answer->getCrosswordId()] = array(
                    'right' => 0,
                    'wrong' => 0
                );
            }

            if ($answer->isCorrect()) {
                $result[$answer->getCrosswordId()]['right']++;
            } else {
                $result[$answer->getCrosswordId()]['wrong']++;
            }
        }
        return $result;
    }

    /**
     *
     * @param int $user_id
     * @return Doctrine_Query
     */
    public function getUserAnswersQuery($user_id) {

        if (empty($user_id) || !is_numeric($user_id)) {
            throw new InvalidArgumentException('User id is missing');
        }

        return $this->getQueryObject()
                ->where('user_id = ?', $user_id);
    }

}