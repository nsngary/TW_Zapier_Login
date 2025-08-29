<?php session_start(); ?>
<?php include "header.php" ?>
<?php
$account = "";
$username = "";
$password = "";

if (isset($_POST['account'])) {
    $account = $_POST['account'];
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $sql = "SELECT * FROM admin where account = '$account'";

    $result = $link->query($sql);
    if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<script>alert('管理者已存在，無法新增。')</script>";
    } else {
        //❌$sql = "INSERT INTO admin (account, password, username)VALUES (?,?,?)";
        $sql = "INSERT INTO admin values('$account', '$password', '$username')";
        $result = $link->query($sql);
        if ($result){
            header("admin.php");
            echo "<script>alert('新增成功！');location.href='admin.php';</script>";
            }
        else 
            echo "<script>alert('新增失敗！')</script>";
    }

}

?>
				<div class="main-content"> 

                    <div class="col-lg-12">
                        <div class="card alert">
                            <div class="card-header">
                                <h2>新增帳號</h2><Br/>
                                 <div class="row">
                                
                                
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <div class="horizontal-form">
                                    <form class="form-horizontal"  method="POST" action="admindetail.php">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">管理者帳號：</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="account" value="<?= $account ?>" class="form-control" placeholder="帳號帳號">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">管理者名稱：</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="username" value="<?= $username ?>" class="form-control" placeholder="帳號名稱">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">管理者密碼：</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="password" value="<?= $password ?>" class="form-control" placeholder="密碼">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-primary btn-flat btn-addon m-b-10 m-l-5"><i class="ti-check"></i>確認</button>
                                                <a href="admin.php"><button type="button" class="btn btn-default btn-flat btn-addon m-b-10 m-l-5"><i class="ti-close"></i>離開</button></a>
                                            </div>
                    
                                        </div>
                                        <div class="form-group">
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                     </div><!-- /# column -->					

						
                </div>
		
<?php include "footer.php" ?>
