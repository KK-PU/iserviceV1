<?php
namespace app\components;

use Yii;
use yii\base\Component;

class DateThai extends Component {

    public function getDate($date = null){

      if(!empty($date) && $date != "0000-00-00"){

              $get_date = explode("-", $date);

              $month =  [Yii::t('app','jan'), Yii::t('app','feb'), Yii::t('app','mar'), Yii::t('app','apr'), Yii::t('app','may'), Yii::t('app','jun'),Yii::t('app','jul'),
               Yii::t('app','aug'),Yii::t('app','sep'), Yii::t('app','oct'), Yii::t('app','nov'), Yii::t('app','dec') ];

        			if($get_date["1"] != "00"){

        				$get_month = $get_date["1"]-1;

        				$get_year = $get_date["0"] + 543;

        				return  Yii::t('app','lang') == 'th' ? $get_date["2"]." ".$month[$get_month]." ".$get_year : $month[$get_month]." ".$get_date["2"].", ".$get_date["0"] ;
        			}

  		}
    }

    public function getDateTime($datetime = null){

      if(!empty($datetime) && $datetime != "0000-00-00 00:00:00"){

        $day = explode(" ",$datetime);

        return $this->dateShortThai($day['0'])." <br>".Yii::t('app','time')." ".substr($day['1'],0,-3);

      }

    }

    public function getDateTimeExport($datetime = null){

      if(!empty($datetime) && $datetime != "0000-00-00 00:00:00"){

        $day = explode(" ",$datetime);

        return $this->dateShortThai($day['0'])." ".Yii::t('app','time')." ".substr($day['1'],0,-3);

      }

    }


    public function dateShortThai($date = null){

        if(!empty($date) && $date != "0000-00-00"){

          $get_date = explode("-", $date);

          $month =  [ Yii::t('app','jan_short'), Yii::t('app','feb_short'), Yii::t('app','mar_short'), Yii::t('app','apr_short')
          , Yii::t('app','may_short'), Yii::t('app','jun_short'),Yii::t('app','jul_short'), Yii::t('app','aug_short'),
           Yii::t('app','sep_short'), Yii::t('app','oct_short'), Yii::t('app','nov_short'), Yii::t('app','dec_short') ];

          if($get_date["1"] != "00"){

            $get_month = $get_date["1"]-1;

            $get_year = $get_date["0"]+543;

            return  Yii::t('app','lang') == 'th' ? $get_date["2"]." ".$month[$get_month]." ".$get_year : $month[$get_month]." ".$get_date["2"].", ".substr($get_date["0"],2) ;

          }
        }
    }

}
