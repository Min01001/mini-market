<?php
require __DIR__ . '/vendor/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

if (isset($_POST['voucher_data']) && !empty($_POST['voucher_data'])) {
    $voucherData = json_decode($_POST['voucher_data'], true);

    // Set up printer
    $connector = new WindowsPrintConnector("BlueTooth Printer");
    $printer = new Printer($connector);

    // Print header
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text("Voucher\n");
    $printer->text("-------------------------------\n");

    // Print voucher items
    foreach ($voucherData as $item) {
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Product: " . $item['product'] . "\n");
        $printer->text("Quantity: " . $item['quantity'] . "\n");
        $printer->text("Price: $" . $item['price'] . "\n");
        $printer->text("-------------------------------\n");
    }

    // Print footer
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text("Thank you for your purchase!\n");

    // Cut and close printer connection
    $printer->cut();
    $printer->close();

    echo "Voucher printed successfully.";
} else {
    echo "No voucher data provided.";
}
?>
