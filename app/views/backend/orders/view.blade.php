@section('title')
Admin | Orders | #{{ $order->id }}
@stop

@section('content')
<div class="page-title">
	<h4>Order #{{ $order->id }}</h4>
</div>

<div class="row-fluid" id="order-app">
	<div class="span10 printcontent">
		<div class="grid simple">
			<div class="grid-body no-border invoice-body">
				<div class="clearfix">
					<div class="pull-left"><h1>{{ $order->restaurant->name }}<h1></div>
					<div class="pull-right"><h4>Customer Invoice</h4></div>
				</div>
				<div class="clearfix"></div>

				<div class="row-fluid" id="invoice-top"><!-- invoice-top start -->
					<div class="span9">
						<h4 class="semi-bold">{{ $order->customer_name }}</h4>
						<address>
							{{ $order->customer_address }}, <br/>
							{{ $order->restaurant->area->name }}, {{ $order->restaurant->city->name }}. <br/>
							<abbr title="Phone">Phone:</abbr> {{ $order->customer_phone }}
						</address>
					</div>

					<div class="span3">
						<div>
		                  <div class="pull-left"> ORDER NO : </div>
		                  <div class="pull-right"> {{ $order->id }} </div>
		                  <div class="clearfix"></div>
                		</div>

	               		<div>
		                  <div class="pull-left"> ORDER DATE : </div>
		                  <div class="pull-right">{{ date("Y/m/d", strtotime($order->created_at)) }}</div>
		                  <div class="clearfix"></div>
	                	</div>
	               		<br />

		                <div class="well well-small green">
		                  <div class="pull-left"> Total Due : </div>
		                  <div class="pull-right"><b class="naira">N</b>{{ number_format($order->total['total'], 2) }}</div>
		                  <div class="clearfix"></div>
		                </div>
					</div>
				</div><!-- invoice-top end -->

				<table class="table">
					<thead>
						<tr>
		                  <th width="60" class="unseen text-center">QTY</th>
		                  <th class="text-left">ITEM NAME</th>
		                  <th width="140" class="text-right">UNIT PRICE</th>
		                  <th width="90" class="text-right">TOTAL</th>
		                </tr>
	                </thead>
	                <tbody>
	                @foreach($order->items as $orderitem)
	              	  <tr>
	              	  	  <td class="unseen text-center">{{ $orderitem->qty }}</td>
		                  <td>{{ $orderitem->item->name }}</td>
		                  <td class="text-right"><b class="naira">N</b>{{ number_format($orderitem->item->price, 2) }}</td>
		                  <td class="text-right"><b class="naira">N</b>{{ number_format(($orderitem->item->price*$orderitem->qty), 2) }}</td>
	              	  </tr>
	                @endforeach
	                	<tr>
		                  <td colspan="2" rowspan="4"><h4 class="semi-bold">Customers Comments</h4>
		                    <p>{{ $order->comments }}.</p>
		                    <h5 class="text-right semi-bold">Thank you for your business</h5></td>
		                  <td class="text-right"><strong>Subtotal</strong></td>
		                  <td class="text-right"><b class="naira">N</b>{{ number_format($order->total['subtotal'], 2) }}</td>
		                </tr>
		                @if($order->type == "delivery")
		                <tr>
		                  <td class="text-right no-border"><strong>Delivery Fee</strong></td>
		                  <td class="text-right"><b class="naira">N</b>{{ number_format($order->restaurant->meta->delivery_fee, 2) }}</td>
		                </tr>
		                @else
		                <tr>
		                  <td class="text-right no-border"><strong>Delivery Fee</strong></td>
		                  <td class="text-right"><b class="naira">N</b>0.00</td>
		                </tr>
		                @endif
		                <tr>
		                  <td class="text-right no-border"><div class="well well-small green"><strong>Total</strong></div></td>
		                  <td class="text-right"><strong><b class="naira">N</b>{{ number_format($order->total['total'], 2) }}</strong></td>
		                </tr>
	                </tbody>
				</table>
				<br />
	            <br />
	            <h5 class="text-right text-black">powered by Chawnow</h5>
			</div>
		</div>

	</div>

	<div class="span2">
		<div class="invoice-button-action-set">
			<?php
				$next = $order->next();
				$previous = $order->previous();
			?>
			<div class="btn-group" style="margin-bottom: 10px;">
				@if($previous)
			  	<a href="/orders/view/{{ $previous->id }}" class="btn btn-primary" rel="tooltip" title="Previous Order"><i class="icon-chevron-left"></i></a>
			  	@else
			  	<a href="#" class="btn btn-primary" rel="tooltip" title="Previous Order"><i class="icon-chevron-left"></i></a>
			  	@endif

			  	@if($next)
			  	<a href="/orders/view/{{ $next->id }}" class="btn btn-primary" rel="tooltip" title="Next Order"><i class="icon-chevron-right"></i></a>
			  	@else
			  	<a href="#" class="btn btn-primary" rel="tooltip" title="Next Order"><i class="icon-chevron-right"></i></a>
			  	@endif
			</div>
		  <p>
		  	@if($order->status == "placed")
		  	<button class="btn btn-default">Status: Placed</button>
		  	@endif
		  	@if($order->status == "verified")
		  	<button class="btn btn-warning">Status: Verified</button>
		  	@endif
		  	@if($order->status == "fulfilled")
		  	<button class="btn btn-success">Status: Fulfilled</button>
		  	@endif
		  </p>

          <p>
            <button class="btn btn-primary" type="button" onclick="window.print()"><i class="icon-print"></i> Print</button>
          </p>
          @if($order->status == "verified")
          <p>
		  	<a href="/orders/{{ $order->id }}/fulfill" class="btn btn-primary"><i class="icon-ok"></i> Fulfill Order</a>
		  </p>
		  @endif
        </div>
	</div>
</div>
@stop