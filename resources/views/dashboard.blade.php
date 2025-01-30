@extends('template')
@section('title','Dashboard')
@section('content')
    <div class="container-xxl" style="min-height:600px">
        {{-- @if (count($data_pemasukan) <= 6)
            <p> Data kurang dari 7 </p>
        @else
        @endif --}}
        <canvas id="lineChart"></canvas>
        <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolore aspernatur quam ut expedita eius autem tenetur necessitatibus fugiat maiores nemo neque et iste explicabo eum labore inventore, nisi placeat blanditiis.
        </p>
    </div>
    @php
        date_default_timezone_set('Asia/Jakarta');
        $today = date('dmy');

        $tanggal = array_fill(0,7,"");
        $pemasukan = array_fill(0,7,0);
        $pengeluaran = array_fill(0,7,0);
        $count = 0;
        foreach ($data_pemasukan as $key) {
            $pemasukan[$count] = $key->total_jumlah;
            $tanggal[$count] = strval($key->tanggal_masuk);
            $count+=1;
        }
        $count = 0;
        foreach ($data_pengeluaran as $key) {
            $pengeluaran[$count] = $key->total_jumlah;
            $count+=1;
        }
    @endphp


    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
    <script >
        var ctxL = document.getElementById("lineChart").getContext('2d');
        var myLineChart = new Chart(ctxL, {
        type: 'line',
        data: {
            labels: ["{{ $tanggal[6] }}", "{{$tanggal[5]}}" , "{{$tanggal[4]}}" , "{{$tanggal[3]}}"  , "{{$tanggal[2]}}", "{{$tanggal[1]}}",  "{{ $tanggal[0] }}"],
            datasets: [{
            label: "Pendapatan",
            data: [{{ $pemasukan[6] }},{{$pemasukan[5]}},{{$pemasukan[4]}},{{$pemasukan[3]}},{{$pemasukan[2]}},{{$pemasukan[1]}},{{$pemasukan[0]}}],
            backgroundColor: [
                'rgba(105, 0, 132, .2)',
            ],
            borderColor: [
                'rgb(6, 255, 0)',
            ],
            borderWidth: 2
            },
            {
            label: "Pengeluaran",
            data: [{{ $pengeluaran[6] }},{{$pengeluaran[5]}},{{$pengeluaran[4]}},{{$pengeluaran[3]}},{{$pengeluaran[2]}},{{$pengeluaran[1]}},{{$pengeluaran[0]}}],
            backgroundColor: [
                'rgba(0, 137, 132, .2)',
            ],
            borderColor: [
                'rgb(255, 23, 0)',
            ],
            borderWidth: 2
            }
            ]
        },
        options: {
            responsive: true
        }
        });
    </script>
@endsection
