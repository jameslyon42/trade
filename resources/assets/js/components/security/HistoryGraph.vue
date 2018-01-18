<template>
    <div class="security-history-graph">
        <canvas ref="chart"></canvas>
    </div>
</template>

<script>
    export default {
        date: function () {
            return {
                chart: false
            };
        },
        props: [
            'security'
        ],
        mounted: function () {
            const ctx = this.$refs.chart;
            this.chart = new Chart(ctx, {
                type: 'line',
                data: this.securityData,
                options: {
                    maintainAspectRatio: false,
                    elements: {
                        line: {
                            tension: 0,
                            backgroundColor: 'rgba(39, 100, 198, .3)',
                            borderColor: 'rgb(39, 100, 198)',
                            borderWidth: 1,
                        },
                        point: {
                            radius: 0
                        }
                    },
                    tooltips: {
                        intersect: false,
                        cornerRadius: 0,
                        callbacks: {
                            label: function (tooltipItems) {
                                return '$' + tooltipItems.yLabel.toFixed(2);
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                callback: function (value) {
                                    return '$' + value.toFixed(2);
                                }
                            }
                        }]
                    }
                }
            });
        },
        computed: {
            securityData: function () {
                const prices = this.security.data.prices;
                const average_durations = this.security.average_durations;
                let labels = [];
                let dataset_prices = [];
                let average_lines = [];
                const colors = ['rgb(21, 119, 34)', 'rgb(114, 29, 19)'];

                prices.forEach(function(price) {
                    const timestamp = moment(price.timestamp, 'YYYY-MM-DD').format('MMM D, YYYY');

                    labels.push(timestamp);

                    dataset_prices.push({
                        x: timestamp,
                        y: price.close
                    });

                    for (let i = 0; i < average_durations.length; i++) {
                        if (!average_lines[i]) {
                            average_lines[i] = [];
                        }

                        average_lines[i].push({
                            x: timestamp,
                            y: price['avg_' + average_durations[i] + '_day']
                        });
                    }
                });

                let datasets = [{
                    data: dataset_prices,
                    label: 'Prices'
                }];

                for (let i = 0; i < average_durations.length; i++) {
                    datasets.push({
                        data: average_lines[i],
                        borderColor: colors[i],
                        fill: false,
                        label: average_durations[i] + ' Day Average'
                    });
                }

                return {
                    labels: labels,
                    datasets: datasets
                };
            }
        },
        watch: {
            security: function () {
                this.chart.data = this.securityData;

                this.chart.update();
            }
        }
    }
</script>