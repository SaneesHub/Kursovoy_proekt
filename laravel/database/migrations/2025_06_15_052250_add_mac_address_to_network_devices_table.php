<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMacAddressToNetworkDevicesTable extends Migration
{
    public function up()
    {
        Schema::table('network_device', function (Blueprint $table) {
            $table->string('mac_address', 17)
                  ->after('ip_address');
        });
    }

    public function down()
    {
        Schema::table('network_device', function (Blueprint $table) {
            $table->dropColumn('mac_address');
        });
    }
}