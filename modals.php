<!-- Login Modal -->
<div class="modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="post">
                    <div class="modal-header pb-0">
                        <h3 class="modal-title" id="loginModalLabel">Login 
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-door-open-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15H1.5zM11 2v13h1V2.5a.5.5 0 0 0-.5-.5H11zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
                            </svg>
                        </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show mt-2" id="loginAlert" role="alert">
                            <span></span>
                            <button type="button" class="close" data-hide="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="form-group">
                            <label for="loginEmail" class="col-form-label">Email:</label>
                            <input type="email" class="form-control" id="loginEmail">
                        </div>

                        <div class="form-group">
                            <label for="loginPassword" class="col-form-label">Password:</label>
                            <input type="password" class="form-control" id="loginPassword" name="password">
                        </div>

                        <div class="row">
                            <div class="col pr-1">
                                <button type="submit" class="btn btn-primary btn-block" id="login" name="login">Login</button>
                            </div>

                            <div class="col pl-1">
                                <button type="button" class="btn btn-outline-success btn-block" data-dismiss="modal" data-toggle="modal" data-target="#registerModal">No Account? Register</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Login Modal -->

    <!--Register Modal -->
    <div class="modal" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form>
                <div class="modal-content">
                    <div class="modal-header pb-0">
                        <h3 class="modal-title" id="registerModalLabel">Register 
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7.5-3a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                        </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="alert alert-danger alert-dismissible fade show mt-2" id="registerAlert" role="alert">
                            <span></span>
                            <button type="button" class="close" data-hide="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="form-group">
                            <label for="firstName" class="col-form-label">Name:</label>

                            <div class="row">
                                <div class="col pr-1">
                                    <input type="text" class="form-control" id="firstName" name="first_name" placeholder="first">
                                </div>

                                <div class="col pl-1">
                                    <input type="text" class="form-control" id="lastName" name="last_name" placeholder="last">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="registerEmail" class="col-form-label">Email:</label>
                            <input type="email" class="form-control" id="registerEmail" name="email">
                        </div>


                        <div class="form-group">
                            <label for="registerPassword" class="col-form-label">Password:</label>
                            <input type="password" class="form-control" id="registerPassword" name="registerPassword">
                        </div>


                        <div class="form-group">
                            <label for="confirmPassword" class="col-form-label">Confirm Password:</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password">
                        </div>
                    
                        <div class="row">
                            <div class="col pr-1">
                                <button type="submit" class="btn btn-primary btn-block" id="register" name="register">Register</button>
                            </div>

                            <div class="col pl-1">
                                <button type="button" class="btn btn-outline-success btn-block" data-dismiss="modal" data-toggle="modal" data-target="#loginModal">Have an Account? Login</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Register Modal -->