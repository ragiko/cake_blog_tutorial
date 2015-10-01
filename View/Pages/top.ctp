<!-- Header -->
<div class="intro-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="intro-message">
                    <h1>Many Heart</h1>
                    <h3>告白でつながる最高のマッチングサービス</h3>
                    <ul class="list-inline intro-social-buttons">
		    <?php
		        echo $this->Html->css(array('bootstrap','bootstrap.min','landing-page'));
			echo $this->Form->create('Users', ['action' => 'login', 'method' => 'post']);
				echo $this->Form->button('Facebookログイン', array('class' => 'btn btn-primary btn-large top-facebook-btn'));
		    ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
</div>
<!-- /.intro-header -->

<!-- Page Content -->
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-6">
                <div class="clearfix"></div>
                <h2 class="section-heading1">あなたの想いを伝える最高のマッチングサービス</h2>
                <p class="lead">あなたは自分の想いを伝えたい相手を選び告白ボタンを押します。</br>そして相手もあなたを選んだ時あなたの告白は相手の元に送り届けられます。</br>
	    また告白を録音しているため自分や相手の告白を何回でも聞くことができます。
	    </a></p>
            </div>
            <div class="col-lg-5 col-lg-offset-2 col-sm-6">
	    <?php echo $this->html->image('4.jpg',array('class' => 'img-responsive ','width' => '80%')); ?>                    
            </div>
        </div>
    </div>
    <!-- /.container -->
</div>
<!-- /.content-section-a -->

<div class="content-section-b">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-lg-offset-1 col-sm-push-6  col-sm-6">
                <div class="clearfix"></div>
                <h2 class="section-heading2">両思いになった時初めて</br>お互いの想いを伝えます！！</h2>
                <p class="lead">お互いが告白ボタンを押した時にお互いの告白が</br>相手の元に届けられます。</br>あなたが何人に告白ボタンを押してもそれは誰にも</br>知られる事がありません。</p>
            </div>
            <div class="col-lg-5 col-sm-pull-6  col-sm-6">
	    <?php echo $this->html->image('deai2.jpg',array('class' => 'img-responsive', 'width' => '100%')); ?>                   
            </div>
        </div>
    </div>
    <!-- /.container -->
</div>

<!-- /.content-section-b -->
<div class="content-section-a">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-6">
                <div class="clearfix"></div>
                <h2 class="section-heading3"></br>告白を聞いた後は電話に切り替わります！</h2>
                <p class="lead">告白を聞いた後は相手に電話がつながります。</br>さあ、明日のデートの予定を決めよう！</p>
            </div>

            <div class="col-lg-5 col-lg-offset-2 col-sm-6">
	    <?php echo $this->html->image('mozaic_01.jpg',array('class' => 'img-responsive')); ?>
            </div>
        </div>
    </div>
    <!-- /.container -->
</div>
<!-- /.content-section-a -->

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p class="copyright text-muted small">Copyright &copy; 100% kosens 2014. All Rights Reserved</p>
            </div>
        </div>
    </div>
</footer>


