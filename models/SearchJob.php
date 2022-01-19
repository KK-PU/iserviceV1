<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Job;

/**
 * SearchJob represents the model behind the search form about `app\models\Job`.
 */
class SearchJob extends Job
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'price', 'job_user_id', 'job_type_id', 'device_id', 'repairman_id'], 'integer'],
            [['job_date', 'job_detail', 'job_start_date', 'job_success_date', 'job_how_to_fix', 'job_status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Job::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'job_date' => $this->job_date,
            'job_start_date' => $this->job_start_date,
            'job_success_date' => $this->job_success_date,
            'price' => $this->price,
            'job_user_id' => $this->job_user_id,
            'job_type_id' => $this->job_type_id,
            'device_id' => $this->device_id,
            'repairman_id' => $this->repairman_id,
        ]);

        $query->andFilterWhere(['like', 'job_detail', $this->job_detail])
            ->andFilterWhere(['like', 'job_how_to_fix', $this->job_how_to_fix])
            ->andFilterWhere(['like', 'job_status', $this->job_status]);

        return $dataProvider;
    }
}
