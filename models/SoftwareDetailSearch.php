<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SoftwareDetail;

/**
 * SoftwareDetailSearch represents the model behind the search form about `app\models\SoftwareDetail`.
 */
class SoftwareDetailSearch extends SoftwareDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'software_type_id'], 'integer'],
            [['software_detail'], 'safe'],
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
        $query = SoftwareDetail::find()->orderBy('software_type_id ASC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'software_type_id' => $this->software_type_id,
        ]);

        $query->andFilterWhere(['like', 'software_detail', $this->software_detail]);

        return $dataProvider;
    }
}
