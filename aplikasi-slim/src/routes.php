<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Respect\Validation\Validator as Respect;
use Respect\Validation\Factory;
// use CustomValidator\Validation\Rules\Identity;

// require __DIR__. '/../Tests/CustomValidator/Validation/Rules/KTPRules.php';
// require __DIR__. '/../Tests/CustomValidator/Validation/Exceptions/KTPException.php';

// // Factory::setDefaultInstance(
// //     (new Factory())
// //         ->withRuleNamespace('CustomValidator\\Validation\\Rules')
// //         ->withExceptionNamespace('CustomValidator\\Validation\\Exceptions')
// // );

return function (App $app) {
    $container = $app->getContainer();

    // View Form Input
    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {
        // $container->get('logger')->info("Slim-Skeleton '/' route");

        return $container->get('renderer')->render($response, 'forminput.php', $args);
    });

    $app->get("/loan/", function (Request $request, Response $response){
        $sql = "SELECT * FROM loan_user";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->get("/loan/{id}", function (Request $request, Response $response, $args){
        $id = $args["id"];
        $sql = "SELECT * FROM loan_user WHERE user_id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id" => $id]);
        $result = $stmt->fetch();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->get("/loan/search/", function (Request $request, Response $response, $args){
        $keyword = $request->getQueryParam("keyword");
        $sql = "SELECT * FROM loan_user WHERE name LIKE '%$keyword%' OR loan_purpose LIKE '%$keyword%'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->post("/inputloan/", function (Request $request, Response $response) use ($container){

        $new_loan_user = $request->getParsedBody();
    
        $sql = "INSERT INTO loan_user (name, ktp, loan_amount, loan_period, loan_purpose, birth_date, sex) 
                VALUE (:name, :ktp, :loan_amount, :loan_period, :loan_purpose, :birth_date, :sex)";
        $stmt = $this->db->prepare($sql);
    
        $data = [
            ":name" => $new_loan_user["name"],
            ":birth_date" => $new_loan_user["birth_date"],
            ":sex" => $new_loan_user["sex"],
            ":ktp" => $new_loan_user["ktp"],
            ":loan_amount" => $new_loan_user["loan_amount"],
            ":loan_period" => $new_loan_user["loan_period"],
            ":loan_purpose" => $new_loan_user["loan_purpose"]
        ];

        $validate = array(
            'name' => Respect::notEmpty()->contains(' ')->length(5, 50),
            'birth_date' => Respect::notEmpty()->date(),
            'sex' => Respect::notEmpty()->in(['M','F'], true),
            // 'ktp' => Respect::notEmpty()->digit()->noWhiteSpace()->length(16, 16),
            'ktp' => Respect::regex("/^\d{6}([04][1-9]|[1256][0-9]|[37][01])(0[1-9]|1[0-2])\d{2}\d{4}$/"),
            'loan_amount' => Respect::notEmpty()->numericVal()->positive()->between(1000, 10000),
            'loan_period' => Respect::notEmpty()->numericVal(),
            'loan_purpose' => Respect::notEmpty()->containsAny(['vacation','renovation', 'electronics', 'wedding', 'rent', 'car', 'investment'])
        );

        $validation = $this->validator->validate($request, $validate);

        if($stmt->execute($data)) {
            // Write successful submission to logs/app.log
            $this->logger->info($new_loan_user["name"].",".$new_loan_user["ktp"].",".$new_loan_user["loan_amount"].",".$new_loan_user["loan_period"].",".
            $new_loan_user["loan_purpose"].",".$new_loan_user["birth_date"].",".$new_loan_user["sex"]);

            return $response->withJson(["status" => "success", "data" => "1"], 200);

        } else {
            return $response->withJson(["status" => "failed", "data" => "0"], 200);
        }
        
            
    });

    $app->put("/loan/{id}", function (Request $request, Response $response, $args){
        $id = $args["id"];
        $loan_user = $request->getParsedBody();
        $sql = "UPDATE loan_user SET name=:name, ktp=:ktp, loan_amount=:loan_amount, loan_period=:loan_period,
                loan_purpose:loan_purpose, birth_date:birth_date, sex:sex WHERE user_id=:id";
        $stmt = $this->db->prepare($sql);
        
        $data = [
            ":id" => $id,
            ":name" => $loan_user["name"],  
            ":ktp" => $loan_user["ktp"],
            ":loan_amount" => $loan_user["loan_amount"],
            ":loan_period" => $loan_user["loan_period"],
            ":loan_purpose" => $loan_user["loan_purpose"],
            ":birth_date" => $loan_user["birth_date"],
            ":sex" => $loan_user["sex"]
        ];
    
        if($stmt->execute($data))
           return $response->withJson(["status" => "success", "data" => "1"], 200);
        
        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->delete("/loan/{id}", function (Request $request, Response $response, $args){
        $id = $args["id"];
        $sql = "DELETE FROM loan_user WHERE user_id=:id";
        $stmt = $this->db->prepare($sql);
        
        $data = [
            ":id" => $id
        ];
    
        if($stmt->execute($data))
           return $response->withJson(["status" => "success", "data" => "1"], 200);
        
        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    
};


