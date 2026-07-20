// Configuration globale de Chart.js
Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
Chart.defaults.color = '#64748b';

document.addEventListener('DOMContentLoaded', () => {
    // Courbes (Line Charts)
    createLineChart1();
    createLineChart2();
    
    // Diagrammes (Bar Charts)
    createBarChart1();
    createBarChart2();
    
    // Fromages (Pie Charts)
    createPieChart1();
    createPieChart2();
});

// ==================== COURBES (LINE CHARTS) ====================

function createLineChart1() {
    const ctx = document.getElementById('lineChart1').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin'],
            datasets: [{
                label: 'Ventes 2024',
                data: [12000, 19000, 15000, 25000, 22000, 30000],
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#6366f1',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6
            }, {
                label: 'Ventes 2023',
                data: [10000, 15000, 12000, 20000, 18000, 25000],
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: { size: 14 }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + ' €';
                        }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
}

function createLineChart2() {
    const ctx = document.getElementById('lineChart2').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
            datasets: [{
                label: 'Température (°C)',
                data: [18, 20, 22, 19, 17, 23, 21],
                borderColor: '#f59e0b',
                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#f59e0b',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: { size: 14 }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    min: 10,
                    max: 30,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: {
                        callback: function(value) {
                            return value + '°C';
                        }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
}

// ==================== DIAGRAMMES (BAR CHARTS) ====================

function createBarChart1() {
    const ctx = document.getElementById('barChart1').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['L1', 'L2', 'L3', 'M1', 'M2'],
            datasets: [{
                label: 'Nombre d\'étudiants',
                data: [150, 120, 100, 80, 60],
                backgroundColor: [
                    'rgba(99, 102, 241, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(139, 92, 246, 0.8)'
                ],
                borderColor: [
                    '#6366f1',
                    '#10b981',
                    '#f59e0b',
                    '#ef4444',
                    '#8b5cf6'
                ],
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
}

function createBarChart2() {
    const ctx = document.getElementById('barChart2').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['T1 2024', 'T2 2024', 'T3 2024', 'T4 2024'],
            datasets: [{
                label: 'Revenus (k€)',
                data: [450, 520, 480, 600],
                backgroundColor: 'rgba(99, 102, 241, 0.8)',
                borderColor: '#6366f1',
                borderWidth: 2,
                borderRadius: 8
            }, {
                label: 'Dépenses (k€)',
                data: [380, 420, 400, 450],
                backgroundColor: 'rgba(239, 68, 68, 0.8)',
                borderColor: '#ef4444',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: { size: 14 }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
}

// ==================== FROMAGES (PIE CHARTS) ====================

function createPieChart1() {
    const ctx = document.getElementById('pieChart1').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Logement', 'Alimentation', 'Transport', 'Loisirs', 'Autres'],
            datasets: [{
                data: [35, 25, 15, 15, 10],
                backgroundColor: [
                    'rgba(99, 102, 241, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(139, 92, 246, 0.8)'
                ],
                borderColor: [
                    '#6366f1',
                    '#10b981',
                    '#f59e0b',
                    '#ef4444',
                    '#8b5cf6'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: { size: 14 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + '%';
                        }
                    }
                }
            }
        }
    });
}

function createPieChart2() {
    const ctx = document.getElementById('pieChart2').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Entreprise A', 'Entreprise B', 'Entreprise C', 'Entreprise D'],
            datasets: [{
                data: [40, 25, 20, 15],
                backgroundColor: [
                    'rgba(99, 102, 241, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderColor: [
                    '#6366f1',
                    '#10b981',
                    '#f59e0b',
                    '#ef4444'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: { size: 14 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + '%';
                        }
                    }
                }
            }
        }
    });
}
