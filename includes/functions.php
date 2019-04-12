<?php    
    function check_admin($db, $user) {
        $query = "SELECT userType from users where username = :username";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', htmlspecialchars($user));
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result['userType'] === 'admin';
    }

    function is_species_avalible($db, $species_name) {
        $query = "SELECT count(mozoSpecies) from mozos where mozoSpecies = :mozoSpecies";
        $statement = $db->prepare($query);
        $statement->bindValue(':mozoSpecies', htmlspecialchars($species_name));
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result[0] === 1;
    }

    function add_mozo($db, $species, $value, $rarity, $info) {
        $query = "INSERT into mozo value (:species, :value, :rarity, FALSE, :info)";
        $statement = $db->prepare($query);
        $statement->bindValue(':species', htmlspecialchars($species));
        $statement->bindValue(':value', intval($value));
        $statement->bindValue(':rarity', intval($rarity));
        $statement->bindValue(':info', htmlspecialchars($info));
        $statement->execute();
        $statement->closeCursor();
    }

    function add_premium_info($db, $species, $price, $quantity) {
        $query = "INSERT into mozo value (:species, :price, ':quantity', 0.00)";
        $statement = $db->prepare($query);
        $statement->bindValue(':species', htmlspecialchars($species));
        $statement->bindValue(':price', floatval($price));
        $statement->bindValue(':quantity', intval($quantity));
        $statement->execute();
        $statement->closeCursor();
    }

    function add_mozo_to_user($db, $mozo_species, $mozo_name, $username) {
        $query = "INSERT into active_mozos(username, mozoSpecies, mozoName) values (:username, :mozo_species, :mozo_name)";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', htmlspecialchars($username));
        $statement->bindValue(':mozo_species', htmlspecialchars($mozo_species));
        $statement->bindValue(':mozo_name', htmlspecialchars($mozo_name));
        $statement->execute();
    }

    function add_purchase_to_user($db, $username, $total) { 
        $query = "INSERT into purchases(username, total) values (:username, :total)";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', htmlspecialchars($username));
        $statement->bindValue(':total', floatval($total));
        $statement->execute();
    }

    function update_mozo($db, $mozo_species, $rarity, $info) {
        $query = 
        "UPDATE mozos
        set 
            mozoRarity = :rarity,
            mozoInfo = :info
        where
            mozoSpecies = :species";
        
        $statement = $db->prepare($query);
        $statement->bindValue(':rarity', intval($rarity));
        $statement->bindValue(':info', htmlspecialchars($info));
        $statement->bindValue(':species', htmlspecialchars($mozo_species));
        $statement->execute();

    }

    function update_premium_info($db, $mozo_species, $quantity, $discount, $info) {
        $query = 
        "UPDATE premium_mozos
        inner join mozos on premium_mozos.mozoSpecies = mozos.mozoSpecies
        set 
            discount = :discount,
            quantity = :quantity, 
            mozos.mozoInfo = :info
        where
            premium_mozos.mozoSpecies = :species";
        
        $statement = $db->prepare($query);
        $statement->bindValue(':discount', floatval($discount));
        $statement->bindValue(':quantity', intval($quantity));
        $statement->bindValue(':info', htmlspecialchars($info));
        $statement->bindValue(':species', htmlspecialchars($mozo_species));
        $statement->execute();
    }

    function update_premium_quantity($db, $mozo_species, $quantity) {
        $query = 
        "UPDATE premium_mozos
        set 
            quantity = :quantity
        where
            mozoSpecies = :species";
        
        $statement = $db->prepare($query);
        $statement->bindValue(':quantity', intval($quantity));
        $statement->bindValue(':species', htmlspecialchars($mozo_species));
        $statement->execute();
    }

    function get_mozos_for_user($db, $username) {
        $query = "SELECT entryID, mozoSpecies, mozoName, hatchedOn, collectedOn from active_mozos where username = :username";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', htmlspecialchars($username));
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $result;
    }

    function get_purchases_for_user($db, $username) {
        $query = "SELECT purchaseDate, total from purchases where username = :username";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', htmlspecialchars($username));
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $result;
    }

    function get_random_mozo($db, $rarity) {
        $query = "SELECT * from mozos where mozoRarity = :mozoRarity and premium = FALSE";
        $statement = $db->prepare($query);
        $statement->bindValue(':mozoRarity', intval($rarity));
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $result[random_int(0, sizeof($result) - 1)];
    }

    function get_all_mozos($db) {
        $query = "SELECT * from mozos";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $result;
    }
    
    function get_all_free_mozos($db) {
        $query = "SELECT * from mozos where premium = FALSE";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $result;
    }

    function get_free_mozo($db, $mozoSpecies) {
        $query = "SELECT mozoValue, mozoRarity, premium, mozoInfo from mozos where mozoSpecies = :mozoSpecies";
        $statement = $db->prepare($query);
        $statement->bindValue(':mozoSpecies', htmlspecialchars($mozoSpecies));
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    }

    function get_all_premium_mozos($db) {
        $query = 
            "SELECT * from 
                mozos 
            inner join premium_mozos on 
                premium_mozos.mozoSpecies = mozos.mozoSpecies
            where 
                premium = TRUE";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $result;
    }

    function get_premium_mozo($db, $mozoSpecies) {
        $query = 
            "SELECT * from 
                mozos 
            inner join premium_mozos on 
                premium_mozos.mozoSpecies = mozos.mozoSpecies
            where 
                premium = TRUE and mozos.mozoSpecies = :mozoSpecies";
        $statement = $db->prepare($query);
        $statement->bindValue(':mozoSpecies', htmlspecialchars($mozoSpecies));
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    }

    function get_all_sellable_mozos($db) {
        $query = 
            "SELECT * from 
                premium_mozos 
            inner join mozos on 
                premium_mozos.mozoSpecies = mozos.mozoSpecies
            where 
                quantity > 0"; 
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $result;
    }

    function get_active_mozo($db, $id) {
        $query = 
            "SELECT * from
                active_mozos
            inner join mozos on
                active_mozos.mozoSpecies = mozos.mozoSpecies
            where
                entryID = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    }

    function get_species_owned($db, $user) {
        $query = 
            "SELECT * from
                active_mozos
            where
                username = :username";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $user);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $unique = array();
        foreach ($result as $mozo) {
            if (!isset($unique[$mozo['mozoSpecies']])) {
                $unique[$mozo['mozoSpecies']] = TRUE;
            }
        }
        return $unique;
    }

    function display_mozos_discovered($db, &$mozos) {
        $counts = array();
        foreach ($mozos as $mozo) {
            $species = $mozo['mozoSpecies'];
            if (isset($counts[$species])) {
                $counts[$species]++;
            } else {
                $counts[$species] = 1;
            }
        }
        foreach ($counts as $mozo=>$count) {
            $details = get_mozo_details($db, $mozo);
            echo "
            <figure>
                <img src='imgs/$mozo'/>
                <figcaption>
                    <h1 class='mozo-name'>$mozo</h1>
                    <p>{$details['mozoInfo']}</p>
                    <p>Number Found: $count</p>
                    <p>Sells for {$details['mozoValue']} coins</p>
                    <p>Rarity: {$details['mozoRarity']}</p> 
            </figure>
            ";
        }
    }


    function random_event() {
        $random = random_int(0, 100);
        if ($random <= 2) {
            return array(
                "message" => "You found a Illisive Mozos!",
                "id" => 1,
                "rarity" => "illusive",
            );
        } else if ($random <= 8) {
            return array(
                "message" => "You found a Rare Mozos!",
                "id" => 2,
                "rarity" => "scarce"
            );
        } else if ($random <= 32) {
            return array(
                "message" => "You found a Mozos!",
                "id" => 3,
                "rarity" => "random"
            );
        } else if ($random <= 64) {
            return array(
                "message" => "You found a Common Mozos!",
                "id" => 4,
                "rarity" => "common",
            );
        } else if ($random <= 100) {
            return array(
                "message" => [
                    "You turn up empty handed...",
                    "You spent the day lost!",
                    "Your Mozo eat you food for the trip, and you had to cancel...",
                    "You found a cool " . ["rock", "stick", "crystal", "tree"][random_int(0, 3)] . "!"
                ][random_int(0, 3)],
                "id" => random_int(5, 8)
            );
        }
    }

    function random_rarity(): int {
        $random = random_int(0, 100);
        if ($random <= 2) {
            return 5;
        } else if ($random <= 8) {
            return 4;
        } else if ($random <= 32) {
            return 3;
        } else if ($random <= 64) {
            return 2;
        } else if ($random <= 100) {
            return 1;
        }
    }

    function rarity_to_word($rarity) {
        switch ($rarity) {
            case -1: return "Premium";
            case 1: return "Common";
            case 2: return "Uncommon";
            case 3: return "Scarce";
            case 4: return "Rare";
            case 5: return "Elusive";
        }
    }

    function load_mozo_images(&$mozos) {
        $loaded = array();
        foreach ($mozos as $mozo) {
            $species = $mozo['mozoSpecies'];
            if (!isset($loaded[$species])) {
                $loaded[$species] = true;
                echo "<img src='imgs/mozos/$species.png' alt='$species'/>";
            }
        }
    }
?>