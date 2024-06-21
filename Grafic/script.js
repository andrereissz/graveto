// script.js

document.getElementById('generateFields').addEventListener('click', function() {
    
    const nConst = parseInt(document.getElementById('rest').value);
    globalThis.numConstraints = nConst;
    const constraintsDiv = document.getElementById('constraints');

    constraintsDiv.innerHTML = '';  // Limpar restrições anteriores

    for (let i = 0; i < nConst; i++) {
        const div = document.createElement('div');
        div.innerHTML = `
            <label for="constraint${i + 1}">Restrição ${i + 1}:</label>
            <input type="number" id="constraint${i + 1}X1" placeholder="Coeficiente de x1">
            <label for="constraint${i + 1}X1">x1 + </label>
            <input type="number" id="constraint${i + 1}X2" placeholder="Coeficiente de x2">
            <label for="constraint${i + 1}X2">x2 ≤ </label>
            <input type="number" id="constraint${i + 1}B" placeholder="Valor de B">
        `;
        constraintsDiv.appendChild(div);
    }

    document.getElementById('inputFields').style.display = 'block';
    document.getElementById('divzona').remove();
});

document.getElementById('solveButton').addEventListener('click', function() {
    //const numConstraints = parseInt(document.getElementById('rest').value);
    
    const objective = {
        x1: parseFloat(document.getElementById('objectiveX1').value),
        x2: parseFloat(document.getElementById('objectiveX2').value)
    };

    const constraints = [];
    for (let i = 0; i < numConstraints; i++) {
        constraints.push({
            x1: parseFloat(document.getElementById(`constraint${i + 1}X1`).value),
            x2: parseFloat(document.getElementById(`constraint${i + 1}X2`).value),
            b: parseFloat(document.getElementById(`constraint${i + 1}B`).value)
        });
    }

    plotGraph(objective, constraints);
});

function findIntersections(constraints) {
    const points = [];

    for (let i = 0; i < constraints.length; i++) {
        const constraint = constraints[i];
        if (constraint.x2 !== 0) {
            // Interseção com o eixo x (y = 0)
            const xIntersect = constraint.b / constraint.x1;
            if (xIntersect >= 0) {
                points.push({ x: xIntersect, y: 0 });
            }
        }
        if (constraint.x1 !== 0) {
            // Interseção com o eixo y (x = 0)
            const yIntersect = constraint.b / constraint.x2;
            if (yIntersect >= 0) {
                points.push({ x: 0, y: yIntersect });
            }
        }
        for (let j = i + 1; j < constraints.length; j++) {
            const A = [
                [constraints[i].x1, constraints[i].x2],
                [constraints[j].x1, constraints[j].x2]
            ];
            const B = [constraints[i].b, constraints[j].b];

            const determinant = A[0][0] * A[1][1] - A[0][1] * A[1][0];
            if (determinant !== 0) {
                const x = (B[0] * A[1][1] - B[1] * A[0][1]) / determinant;
                const y = (A[0][0] * B[1] - A[1][0] * B[0]) / determinant;
                if (x >= 0 && y >= 0) { // considerando apenas o quadrante positivo
                    points.push({ x, y });
                }
            }
        }
    }

    return points;
}

// Função para verificar se um ponto está na região viável
function isPointInFeasibleRegion(point, constraints) {
    return constraints.every(constraint => constraint.x1 * point.x + constraint.x2 * point.y <= constraint.b) &&
           point.x >= 0 && point.y >= 0;
}

// Função principal para plotar o gráfico
function plotGraph(objective, constraints) {
    const xValues = Array.from({ length: 41 }, (_, i) => i); // Valores para x1
    const yValues = Array.from({ length: 41 }, (_, i) => i); // Valores para x2

    // Cálculo dos valores da função objetivo em cada ponto da grade
    const zValues = yValues.map(y =>
        xValues.map(x => objective.x1 * x + objective.x2 * y)
    );

    // Restrições para o plot
    const traces = constraints.map((constraint, index) => {
        const yLineValues = xValues.map(x => (constraint.b - constraint.x1 * x) / constraint.x2);
        return {
            x: xValues,
            y: yLineValues.map(y => Math.max(y, 0)), // Garantir que a linha esteja acima de y=0
            fill: 'tozeroy', // Preencher abaixo da linha até o eixo y=0
            mode: 'none',
            name: `Restrição ${index + 1}`
        };
    });

    const layout = {
        title: 'Métodos Gráficos para Programação Linear',
        xaxis: { title: 'x1' },
        yaxis: { title: 'x2' }
    };

    // Encontrar interseções entre as restrições
    const intersections = findIntersections(constraints);
    const feasiblePoints = intersections.filter(point => isPointInFeasibleRegion(point, constraints));

    // Calcular os valores da função objetivo nos pontos viáveis
    const objectiveValues = feasiblePoints.map(point => ({
        x: point.x,
        y: point.y,
        z: objective.x1 * point.x + objective.x2 * point.y
    }));

    // Encontrar a solução ótima
    const optimalPoint = objectiveValues.reduce((prev, current) => (
        current.z > prev.z ? current : prev
    ));

    // Marcador para o ponto ótimo
    const optimalPointMarker = {
        x: [optimalPoint.x],
        y: [optimalPoint.y],
        mode: 'markers',
        name: 'Solução Ótima',
        marker: { color: 'green', size: 12 }
    };

    // Trace dos pontos de interseção
    // const intersectionPoints = {
    //     x: feasiblePoints.map(point => point.x),
    //     y: feasiblePoints.map(point => point.y),
    //     mode: 'markers',
    //     name: 'Pontos de Interseção',
    //     marker: { color: 'red', size: 10 }
    // };

    // Adicionar todos os traces ao gráfico
    const allTraces = [...traces, optimalPointMarker];

    // Criar o gráfico utilizando Plotly
    Plotly.newPlot('plot', allTraces, layout);
    document.getElementById('plot').style.display = 'block';

    console.log('Solução Ótima encontrada em:', optimalPoint);
}
