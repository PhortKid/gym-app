<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $customer->receipt_no }}</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            line-height: 1.4;
            margin: 0;
            padding: 10px;
            font-size: 12px;
        }

        .thermal-receipt {
            max-width: 80mm;
            margin: 0 auto;
            padding: 5px;
        }

        .receipt-header, .receipt-footer, .qr-code {
            text-align: center;
        }

        .receipt-header h1 {
            margin: 5px 0;
            font-size: 16px;
        }

        .receipt-header p,
        .receipt-footer p {
            margin: 3px 0;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            text-align: left;
            padding: 3px 0;
        }

        .text-right {
            text-align: right;
        }

        .receipt-total {
            font-weight: bold;
            text-align: righTt;
        }

        .print-controls {
            text-align: center;
            margin: 20px 0;
        }

        @media print {
            @page {
                size: 80mm auto;
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
            }

            .print-controls, button, .no-print {
                display: none !important;
            }

            .thermal-receipt {
                max-width: 100%;
                width: 100%;
                padding: 0;
            }

            tr, .receipt-header, .receipt-footer {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body  @if(isset(Auth::user()->name)) contenteditable="true"  @endif >
    
    
    @if(isset(Auth::user()->name))
    <div class="print-controls no-print">
        <button onclick="window.print()" style="padding: 8px 16px; background-color: yellow; color: black; border: none; cursor: pointer;">Print Receipt</button>
        <button onclick="window.close()" style="padding: 8px 16px; background-color: yellow; color: black; border: none; cursor: pointer; margin-left: 10px;">Close</button>
    </div>
    @endif

    <div class="thermal-receipt">
        <div class="receipt-header">
            <p>*** START OF LEGAL RECEIPT ***</p>
        <img src="{{ asset('/favicon.png') }}" alt="Company Logo" style="width: 80px; height: auto; margin-bottom: 5px;">
            
            <h1>Amazing Fitness Gym</h1>
            <p>P.O. BOX 1087</p>
            <p>Iringa , TANZANIA</p>
            <p>TIN: </p>
           {{-- <p>VRN: *NOT REGISTERED*</p>
            <p>SERIAL: </p>
            <p>UIN: </p>--}}
            
        </div>

        <div class="divider"></div>

        <p><strong>CUSTOMER NAME:</strong> {{ $customer->full_name }} </p>
        {{--   <p><strong>CUSTOMER ID TYPE:</strong></p>--}}
        <p><strong>CUSTOMER ID:</strong> 1000{{ $customer->id }}</p>
       
 <div class="divider"></div>
        <p><strong>RECEIPT NUMBER:</strong> {{ $customer->card_number}}</p>
        {{--  <p><strong>Z-NUMBER:</strong></p>--}}
        <p><strong>RECEIPT DATE:</strong> {{ now()->format('d-m-Y') }}</p>
        <p><strong>RECEIPT TIME:</strong> {{ now()  }}</p>
      

        <div class="divider"></div>
        Purchased Items
           <div class="divider"></div>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                
                    <tr>
                        <td>Service</td>
                        <td class="text-right">1</td>
                        <td class="text-right">{{ number_format($customer->amount, 2, '.', "'") }}</td>
                    </tr>
               
            </tbody>
        </table>

        <div class="divider"></div>

        <div class="receipt-total">
        {{-- <p><strong>TRANSPORTATION:</strong> 0.00</p>--}}
            {{-- <p><strong>TOTAL EXCLUSIVE OF TAX:</strong> 0.00</p>--}}
                {{--   <p><strong>TOTAL INCLUSIVE OF TAX:</strong> 0.00</p>--}}
                    {{--  <p><strong>TOTAL TAX:</strong> 0.00</p>--}}
            <p><strong>CASH:</strong> {{ number_format($customer->amount, 2, '.', "'") }}</p>
            <p><strong>PAYMENT METHOD:</strong> {{ ucfirst($customer->payment_method) }}</p>
        </div>

       

        <div class="divider"></div>

        <div class="qr-code">
            <p>RECEIPT VERIFICATION CODE</p>
            <p><strong>{{ $customer->card_no }}</strong></p>
            {!! $qrCode !!}
            <p>*** END OF LEGAL RECEIPT ***</p>
        </div>
    </div>
    @if(isset(Auth::user()->firstname))
    <script>
        window.onload = function() {
            setTimeout(function () {
                window.print();
            }, 500);
        };
    </script>
       @endif
</body>
</html>