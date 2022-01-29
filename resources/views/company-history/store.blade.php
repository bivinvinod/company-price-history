<x-layout>
    <div class="row text-center">
        <h1>{{ $selectedCompany['Company Name'] }}</h1>
    </div>
    <div class="row mt-5">
        <canvas id="myChart" width="100" height="25"></canvas>
    </div>
    <div class="row mt-5">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Open</th>
                <th scope="col">High</th>
                <th scope="col">Low</th>
                <th scope="col">Close</th>
                <th scope="col">Volume</th>
            </tr>
            </thead>
            <tbody>
            @foreach($companyData as $data)
                <tr>
                    <td>{{ \Carbon\Carbon::createFromTimestamp($data['date'])->format('Y-m-d') }}</td>
                    <td>{{ $data['open'] }}</td>
                    <td>{{ $data['high'] }}</td>
                    <td>{{ $data['low'] }}</td>
                    <td>{{ $data['close'] }}</td>
                    <td>{{ $data['volume'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <x-slot name="javascript">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"
                integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            const ctx = document.getElementById('myChart').getContext('2d');
            const data = {{ Illuminate\Support\Js::from(array_values($companyData)) }};
            const points = [];
            const labels = [];
            data.forEach(function (e) {
                labels.push(new Date(e.date * 1000).toISOString().substring(0, 10));
                points.push(e.open);
                labels.push(new Date(e.date * 1000).toISOString().substring(0, 10));
                points.push(e.close);
            });
            ;
            const myChart = new Chart(ctx, {
                type: 'line',
                options: {
                    plugins: {
                        legend: {
                            display: false,
                        }
                    }
                },
                data:
                    {
                        datasets: [{
                            data: points,
                            label: 'price',
                            fill: false,
                            borderWidth: 1,
                            pointRadius: 3,
                            tension: 0,
                            borderColor: '#182d52',
                            backgroundColor: '#d4d6d9'
                        }],
                        labels: labels
                    },
            });
        </script>
    </x-slot>
</x-layout>
