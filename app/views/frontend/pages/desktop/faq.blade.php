@section('title')
Help And FAQs - Chawnow | Online Food Ordering 
@stop

@section('page_class') help-page @stop

@section('scripts')
{{ HTML::script('assets/js/frontend/views/help/index.js') }}
<!--<script type="text/javascript" src="{{ cdn( '/assets/js/master.min.js' ) }}"></script>-->
<script type="text/javascript">
$(document).ready(function() {
	var view = new Chawnow.Views.Helppage();
});
</script>
@stop

@section('content')
<div class="page-content container">

	<div class="row">
		<div class="col-md-12 help-page-content">

			<div class="card help-content clearfix">
				<div class="pull-left help-block">
					<h2>Frequently Asked Questions</h2>
					<h4>Click a question to see the answer</h4>

					<div class="question-box" id="">
						<p class="question">What is Chawnow all about?</p>
						<p class="answer">
							Chawnow provides customers with an easy and secure way to order from their favourite restaurant in their area.
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">How does Chawnow work</p>
						<p class="answer">
							Enter your city and area and we'll find restaurants near you, select a restaurant and build your meal and checkout your order. Chawnow will take care of the rest for you!

						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">What kind of restaurants do you have on Chawnow?</p>
						<p class="answer">
							Chawnow offers you a wide range of restaurants serving different cuisines to soothe your appetite
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">Help! I have more questions. Who can I speak to?</p>
						<p class="answer">
							You can contact our customer care department at 07068181972 or 07031017543 or send us a mail at info@chawnow.com.
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">What is your price range like?</p>
						<p class="answer">
							The cost of your meal depends on the number of orders you make. We have restaurants for everyone, so just browse around and order what you like.
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">How do i pay for my order?</p>
						<p class="answer">
							We only accept cash on delivery right now. Others payment methods to make online food ordering as convenient as possible coming soon.
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">How long will the delivery take?</p>
						<p class="answer">
							Delivery time depends on the number of orders and the distance from the restaurant to your delivery address. Once your order has been processed, we will send you a SMS regarding your confirmation and expected delivery time.
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">Is your site secure?</p>
						<p class="answer">
							Our website is secure and uses the latest technology to encrypt your information. Our customer care department makes sure every order goes out to the restaurant correctly.
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">Do i need to have an account to use Chawnow?</p>
						<p class="answer">
							Anyone can use our service. 
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">How do I sign up for a Chawnow account?</p>
						<p class="answer">
							Click on the sign in tab which is located on the top right hand side of the home page, fill in your details as requested before clicking 'Submit'. Registration should now be completed and you should receive a confirmation email to the email address you registered with. Once you have registered, you will be able to order delicious cuisines from your area!
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">Are there are any membership fees?</p>
						<p class="answer">
							No there are memberships fees.
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">Can I cancel my order?</p>
						<p class="answer">
							Call the restaurant to change the order. After leaving the restaurant it is not possible to change. 
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">How do I make changes to my order?</p>
						<p class="answer">
							Just give us a call at 07068181972 and we can change your order for you. However if the delivery has been discharged already, no changes can be made.
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">The food I ordered is unacceptable. How do I get a refund?</p>
						<p class="answer">
							Chawnow provides an easy way for you to order food online, we are not responsible for the preparation/cooking/delivery of the food. If you're unhappy with the quality of the food, you can contact us and we can contact the restaurant on your behalf to inform them of your dissatisfaction, and to see what they will offer you in compensation. You can contact us at 07068181972 or 07031017543.
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">Can I combine orders from a list of restaurants??</p>
						<p class="answer">
							No. In order avoid confusion and other problem you can only order from one restaurant at a time.
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">Can I cancel my order?</p>
						<p class="answer">
							Call the restaurant to change the order. After leaving the restaurant it is not possible to change. 
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">How do I know if my order got through?</p>
						<p class="answer">
							You will receive a confirmation email from us, stating the orders you have selected and the time it will take to be delivered to you. We will also send you a SMS to keep you updated once the restaurant has confirmed your order. 
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">Where is my food? Who do I call to check on my food?</p>
						<p class="answer">
							Chawnow is only responsible for forwarding the orders to the restaurants and has no control over the actual delivery. However we will do all we can to help you; you can contact our customer care department who will investigate on your behalf. You can contact us at 07068181972.
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">I did not receive what I ordered. Why did this happen?</p>
						<p class="answer">
							There may be times when a mistake has been made and items from your order are missing when the delivery is made. If possible, you should go through your delivery with the driver to confirm the correct items have been delivered. If something is missing, you can contact us and we can contact the takeaway on your behalf as soon as possible so the takeaway can be given the opportunity to resolve the problem. You can contact us at 07068181972.
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">If the delivery is late, do I get some discount?</p>
						<p class="answer">
							Chawnow is only responsible for forwarding the orders to the restaurants and has no control over the actual delivery. However we will do all we can to help you; you can contact us and we can contact the takeaway on your behalf as soon as possible to investigate. Give us a call or drop us a line and we will try to help you out.
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">What if I'm not at home when the delivery man comes by? Will they redeliver?</p>
						<p class="answer">
							You will receive a confirmation email and a SMS from us, stating the delivery time of your order so you will be able to arrange for someone to be home when the delivery man comes by. Unfortunately, redelivery is not possible.
						</p>
					</div>

					<div class="question-box" id="">
						<p class="question">How do I provide feedback?</p>
						<p class="answer">
							You can contact our customer care department at 07068181972 or you send us a mail at info@chawnow.com.
						</p>
					</div>
				</div>

				<div class="pull-right call-to-action">
					<div class="inner">
					<p>
						Do you have any questions? Is there anything we can help you with?. We have collected the most frequent questions and we have put ourselves in your shoes to meet your needs.<br>
						Have a look! And if you do not find the answer to your question, do not forget that we are at your disposal!
					</p>
					</div>
				</div>
			</div>

		</div>
	</div>

</div>
@stop