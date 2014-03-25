<?php
class AdModel {
	//Cette page ne devrait contenir aucun html.
	public $ad;

    public function __construct() {
        $date = new DateTime();
        $this->ad->meta = new stdClass();
        $this->ad->meta->id = $date->getTimestamp() . rand(0, 100);
        $this->ad->meta->noClient = $_POST["noClient"];
        $this->ad->meta->noAd = $_POST["noAd"];
        $this->ad->meta->date = date("c");
        $this->ad->meta->category = $_POST["category"];
        $this->ad->meta->format = $_POST["format"];

        $this->ad->url = URL;
        $this->ad->w = intval(explode("x", $this->ad->meta->format)[0]);
        $this->ad->h = intval(explode("x", $this->ad->meta->format)[1]);
        $this->ad->folder = 'temps/' . $this->ad->meta->id;
        $this->ad->assets = $this->ad->folder . '/assets/';
        $this->createFolder($this->ad->folder);
        $this->ad->logo = new stdClass();
        $this->ad->logo->tmp = $_FILES['logo']['tmp_name'];
        $this->ad->logo->defaultName = $_FILES['logo']['name'];
        $this->ad->logo->ext = end(explode(".", $this->ad->logo->defaultName));
        $this->ad->logo->name = $this->ad->assets . 'logo.' . $this->ad->logo->ext;
        move_uploaded_file($this->ad->logo->tmp, $this->ad->assets . 'logo.' . $this->ad->logo->ext);

        $id = explode(",", $_POST["offersId"]);
        $this->ad->offers = new stdClass();
        $this->ad->offers->nbr = count($id);
        $this->ad->offers->list = [];
        $this->ad->offers->gallery = $this->ad->offers->nbr > 1 ? true : false;

        $this->ad->scroller = new stdClass();
        $this->ad->scroller->w = $this->ad->w * $this->ad->offers->nbr;

        for($x=0; $x<$this->ad->offers->nbr; $x++) {
            $obj = new stdClass();
            /* ID */
            $obj->id = $id[$x];
            /* Index */
            $obj->index = $x + 1;
            /* Destination */
            $obj->destination = $_POST[$obj->id . "_destination"];
            /* More Destination */
            $obj->moreDestination = $_POST[$obj->id . "_moreDestination"];
            /* Price */
            if(isset($_POST[$obj->id . "_price"])) {
                $price = intval($_POST[$obj->id . "_price"]);
                $price = number_format($price, 0, '',' ');
                $obj->price = $price;
            }
            /* Date */
            if(isset($_POST[$obj->id . "_date"])) {
                $obj->date = $_POST[$obj->id . "_date"];
            }
            /* Mentions */
            $obj->mentions = [];
            /* Mention 1 */
            $mention1 = $_POST[$obj->id . "_mention_1"] === "freetext" ? $_POST[$obj->id . "_mention_1_freetext"] : $_POST[$obj->id . "_mention_1"];
            if($mention1 !== "") {
                array_push($obj->mentions, $mention1);
            }
            /* Mention 2 */
            $mention2 = $_POST[$obj->id . "_mention_2"] === "freetext" ? $_POST[$obj->id . "_mention_2_freetext"] : $_POST[$obj->id . "_mention_2"];
            if($mention2 !== "") {
                array_push($obj->mentions, $mention2);
            }
            /* Rating */
            $obj->rating = intval($_POST[$obj->id . "_rating"]);
            /* Link */
            $obj->link = $_POST[$obj->id . "_link"];
            /* Image(s) */
            $obj->pictures = array();
            foreach($_FILES[$obj->id . '_picture']['tmp_name'] as $key => $tmp_name) {
                $name = $_FILES[$obj->id . '_picture']['name'][$key];
                array_push($obj->pictures, $this->ad->assets . $name);
                move_uploaded_file($_FILES[$obj->id . '_picture']['tmp_name'][$key], $this->ad->assets. $name);
            }
            /* Description */
            $obj->description = $_POST[$obj->id . "_description"];
            /* Légal */
            $obj->legal = $_POST[$obj->id . "_legal"];

            array_push($this->ad->offers->list, $obj);
        }
        //print_r($this->ad);
    }

    private function createFolder($folder) {
        rrmdir($folder);
        umask(0);
        if(!mkdir($folder, 0777, true)) {
            die('Echec lors de la création du répertoire');
        }
        mkdir($folder, 0777, true);
        mkdir($folder ."/assets", 0777, true);
    }
}
?>