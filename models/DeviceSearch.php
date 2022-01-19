<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Device;

/**
 * DeviceSearch represents the model behind the search form about `app\models\Device`.
 */
class DeviceSearch extends Device
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'device_type_id', 'department_id'], 'integer'],
            [['device_id', 'serial_no', 'device_brand', 'device_model', 'device_name', 'memory', 'cpu', 'harddisk', 'monitor', 'other_detail', 'device_ip', 'date_use', 'date_expire', 'device_docs', 'device_status'], 'safe'],
            [['device_price'], 'number'],
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
        $query = Device::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date_use' => $this->date_use,
            'date_expire' => $this->date_expire,
            'device_price' => $this->device_price,
            'device_type_id' => $this->device_type_id,
            'department_id' => $this->department_id,
        ]);

        $query->andFilterWhere(['like', 'device_id', $this->device_id])
            ->andFilterWhere(['like', 'serial_no', $this->serial_no])
            ->andFilterWhere(['like', 'device_brand', $this->device_brand])
            ->andFilterWhere(['like', 'device_model', $this->device_model])
            ->andFilterWhere(['like', 'device_name', $this->device_name])
            ->andFilterWhere(['like', 'memory', $this->memory])
            ->andFilterWhere(['like', 'cpu', $this->cpu])
            ->andFilterWhere(['like', 'harddisk', $this->harddisk])
            ->andFilterWhere(['like', 'monitor', $this->monitor])
            ->andFilterWhere(['like', 'other_detail', $this->other_detail])
            ->andFilterWhere(['like', 'device_ip', $this->device_ip])
            ->andFilterWhere(['like', 'device_docs', $this->device_docs])
            ->andFilterWhere(['like', 'device_status', $this->device_status]);

        return $dataProvider;
    }
}
