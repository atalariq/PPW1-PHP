// Calculator — PPW1 Pertemuan 11
// Handles add, subtract, multiply, divide on two numbers.

const num1 = document.getElementById('num1');
const num2 = document.getElementById('num2');
const result = document.getElementById('result');

function getValues() {
  const a = parseFloat(num1.value);
  const b = parseFloat(num2.value);

  if (isNaN(a) || isNaN(b)) {
    result.textContent = 'Please enter valid numbers.';
    return null;
  }

  return { a, b };
}

function calculate(operation) {
  const values = getValues();
  if (!values) return;

  const { a, b } = values;
  let output;

  switch (operation) {
    case 'add':
      output = a + b;
      break;
    case 'subtract':
      output = a - b;
      break;
    case 'multiply':
      output = a * b;
      break;
    case 'divide':
      if (b === 0) {
        result.textContent = 'Cannot divide by zero.';
        return;
      }
      output = a / b;
      break;
  }

  result.textContent = output;
}

document.getElementById('btn-add').addEventListener('click', () => calculate('add'));
document.getElementById('btn-subtract').addEventListener('click', () => calculate('subtract'));
document.getElementById('btn-multiply').addEventListener('click', () => calculate('multiply'));
document.getElementById('btn-divide').addEventListener('click', () => calculate('divide'));
