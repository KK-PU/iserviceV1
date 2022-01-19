<?php
namespace app\components;

use Yii;
use yii\base\Component;

class Custom extends Component {

  public function getStatusColor($status = null){

      if($status == "request"){

  		return "<span style='color:#000099'>".Yii::t('app','request_status')."</span>";

  		}else if($status == "wait"){

        return "<span style='color:#d99228'>".Yii::t('app','wait_status')."</span>";

      }else if($status == "claim"){

        return "<span style='color:#000099'>".Yii::t('app','claim_status')."</span>";

      }else if($status == "process"){

        return "<span style='color:#d99228'>".Yii::t('app','process_status')."</span>";

      }else if($status == "success"){

        return "<span style='color:#009900'>".Yii::t('app','success_status')."</span>";

      }else if($status == "cancel"){

        return "<span style='color:#cc3300'>".Yii::t('app','cancel_status')."</span>";

      }
	}


  public function getStatus($status = null){

      if($status == "request"){

      return Yii::t('app','request_status');

      }else if($status == "wait"){

        return Yii::t('app','wait_status');

      }else if($status == "claim"){

        return Yii::t('app','claim_status');

      }else if($status == "process"){

        return Yii::t('app','process_status');

      }else if($status == "success"){

        return Yii::t('app','success_status');

      }else if($status == "cancel"){

        return Yii::t('app','cancel_status');

      }
  }

}
