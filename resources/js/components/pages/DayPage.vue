<script>
import DayItem from '../DayItem.vue';

export default {
    data() {
        return {
            itineraries: [
                { "id": "1", "tour_id": "2", "place_id": "3", "city_start_id": "190389", "city_destination_id": "264408", "typeitinerary_id": "4", "contact_id": "8", "supplier_id": "10", "name": "Craig Bahringer", "startdate": "2023-12-15 06:30:00", "enddate": "2023-12-22 00:00:00", "notes": "Officia aperiam dicta quia molestiae veniam magni libero. Ut sed doloribus minima non excepturi eos ducimus. Quia magni voluptatem odio quidem. Voluptatibus ea perferendis amet tenetur velit veniam totam.", "outoflour": "1", "carrier": "Clementina Schultz", "carrier_id": "SVKMDEX0", "showcheck": "14:12:25", "showtime": "21:57:46", "notify": "0", "created_at": "2023-12-10 13:57:42", "updated_at": "2023-12-10 13:57:42" },
                { "id": "2", "tour_id": "2", "place_id": "2", "city_start_id": "102250", "city_destination_id": "154879", "typeitinerary_id": "7", "contact_id": "8", "supplier_id": "1", "name": "Prof. Jacky Leannon", "startdate": "2023-12-17 07:30:00", "enddate": "2023-12-19 00:00:00", "notes": "Rerum quos assumenda est veritatis dolorum. Aut sed delectus nihil ut. Omnis est enim saepe. Odit dolores qui ut ut earum.", "outoflour": "0", "carrier": "Dr. Larry Kuvalis I", "carrier_id": "FOVGRE7Y", "showcheck": "19:56:26", "showtime": "15:55:15", "notify": "0", "created_at": "2023-12-10 13:57:42", "updated_at": "2023-12-10 13:57:42" },
                { "id": "3", "tour_id": "2", "place_id": "7", "city_start_id": "138521", "city_destination_id": "157566", "typeitinerary_id": "4", "contact_id": "7", "supplier_id": "3", "name": "Ms. Laney Kreiger", "startdate": "2023-12-17 08:10:00", "enddate": "2023-12-20 00:00:00", "notes": "Natus et doloribus qui veniam. Veritatis quisquam sint sed rerum ducimus eos.", "outoflour": "0", "carrier": "Prof. Shaun Howell Sr.", "carrier_id": "CVKQNBGS", "showcheck": "15:55:20", "showtime": "01:01:40", "notify": "0", "created_at": "2023-12-10 13:57:42", "updated_at": "2023-12-10 13:57:42" },
                { "id": "4", "tour_id": "2", "place_id": "1", "city_start_id": "137286", "city_destination_id": "60688", "typeitinerary_id": "3", "contact_id": "4", "supplier_id": "9", "name": "Joyce Tremblay", "startdate": "2023-12-16 11:50:00", "enddate": "2023-12-19 00:00:00", "notes": "Dolorem velit molestiae rem ullam autem. Eum laboriosam aut totam. Eligendi ullam ut voluptate necessitatibus. Deserunt praesentium qui quo distinctio ea illo non.", "outoflour": "1", "carrier": "Verda Koepp", "carrier_id": "BOBDFFG6", "showcheck": "21:31:25", "showtime": "23:16:19", "notify": "0", "created_at": "2023-12-10 13:57:42", "updated_at": "2023-12-10 13:57:42" },
                { "id": "5", "tour_id": "2", "place_id": "2", "city_start_id": "172468", "city_destination_id": "20979", "typeitinerary_id": "5", "contact_id": "2", "supplier_id": "4", "name": "Sheridan Sawayn", "startdate": "2023-12-14 12:30:00", "enddate": "2023-12-19 00:00:00", "notes": "Voluptas adipisci unde aspernatur voluptatem assumenda. Eveniet inventore officia odio est similique provident enim. Ut maiores officiis vitae dicta.", "outoflour": "1", "carrier": "Jennie Hills", "carrier_id": "SMQTKTNC", "showcheck": "11:55:40", "showtime": "04:10:59", "notify": "0", "created_at": "2023-12-10 13:57:42", "updated_at": "2023-12-10 13:57:42" },
                { "id": "6", "tour_id": "2", "place_id": "9", "city_start_id": "261286", "city_destination_id": "173843", "typeitinerary_id": "5", "contact_id": "5", "supplier_id": "6", "name": "Walton Blick PhD", "startdate": "2023-12-15 14:20:00", "enddate": "2023-12-20 00:00:00", "notes": "Aut eaque expedita ut facere quasi quibusdam labore. Deserunt qui ipsam facere qui architecto suscipit aliquam. Sunt ut laboriosam provident quas. Veniam distinctio est doloribus sapiente. Commodi velit doloribus laborum repellat.", "outoflour": "0", "carrier": "Mr. Montana Skiles", "carrier_id": "VGQPIH3O", "showcheck": "06:32:32", "showtime": "22:02:55", "notify": "0", "created_at": "2023-12-10 13:57:42", "updated_at": "2023-12-10 13:57:42" },
                { "id": "7", "tour_id": "2", "place_id": "2", "city_start_id": "98874", "city_destination_id": "176443", "typeitinerary_id": "7", "contact_id": "2", "supplier_id": "9", "name": "Meaghan Walker", "startdate": "2023-12-18 16:00:00", "enddate": "2023-12-18 00:00:00", "notes": "Labore nisi dolor accusamus omnis. Ut iusto magni autem eaque similique omnis sunt. Incidunt aut aut accusantium quia ut recusandae et. Autem recusandae eos sapiente id voluptatem.", "outoflour": "0", "carrier": "Minerva Aufderhar PhD", "carrier_id": "LSPIYQZ7EDB", "showcheck": "22:09:43", "showtime": "21:57:29", "notify": "0", "created_at": "2023-12-10 13:57:42", "updated_at": "2023-12-10 13:57:42" },
                { "id": "8", "tour_id": "2", "place_id": "5", "city_start_id": "212174", "city_destination_id": "77041", "typeitinerary_id": "5", "contact_id": "9", "supplier_id": "7", "name": "Harley Kutch", "startdate": "2023-12-14 19:40:00", "enddate": "2023-12-21 00:00:00", "notes": "Quaerat quia distinctio labore corrupti nihil sunt illo. Ab alias odit sint vel. Qui dignissimos eveniet facere.", "outoflour": "1", "carrier": "Diego O'Connell I", "carrier_id": "TCWDRGH2", "showcheck": "04:54:01", "showtime": "07:43:55", "notify": "0", "created_at": "2023-12-10 13:57:42", "updated_at": "2023-12-10 13:57:42" },
                { "id": "9", "tour_id": "2", "place_id": "10", "city_start_id": "202791", "city_destination_id": "85387", "typeitinerary_id": "5", "contact_id": "7", "supplier_id": "1", "name": "Mr. Herman Heathcote", "startdate": "2023-12-15 15:23:00", "enddate": "2023-12-21 00:00:00", "notes": "Et aliquam nobis et nemo qui beatae eum omnis. In quia rerum nostrum velit. Facilis nemo incidunt error eveniet soluta sunt.", "outoflour": "1", "carrier": "Russ McDermott", "carrier_id": "ZEPOSQBRF3D", "showcheck": "10:02:06", "showtime": "11:34:49", "notify": "0", "created_at": "2023-12-10 13:57:42", "updated_at": "2023-12-10 13:57:42" },
                { "id": "10", "tour_id": "2", "place_id": "10", "city_start_id": "180826", "city_destination_id": "160187", "typeitinerary_id": "8", "contact_id": "5", "supplier_id": "4", "name": "Daniela Mueller", "startdate": "2023-12-20 08:32:00", "enddate": "2023-12-19 00:00:00", "notes": "Ut et ut perspiciatis rerum cum sed molestiae tempore. Sed quos at veritatis sequi animi est qui dolor.", "outoflour": "0", "carrier": "Trace Treutel", "carrier_id": "RYZWCYDQ", "showcheck": "00:01:03", "showtime": "21:39:23", "notify": "0", "created_at": "2023-12-10 13:57:42", "updated_at": "2023-12-10 13:57:42" }
            ],
        };
    },
    components: { DayItem }
}
</script>
<template>
    <div class="w-full p-2">
        <h1
            class="font-bold bg-gradient-to-tr from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
            Martes 10 de diciembre del 2023</h1>
        <div class="flex justify-center">
            <div>
                <DayItem />
                <DayItem />
                <DayItem />
                <DayItem />
                <DayItem />
                <DayItem />
                <DayItem />
            </div>
        </div>
    </div>
</template>
<style scoped>
h1 {
    font-family: 'Archivo Black', sans-serif;
}
</style>
