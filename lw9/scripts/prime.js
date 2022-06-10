function isPrimeNumber(number) {
    if (number instanceof Array) {
        number.forEach(num => isPrimeNumber(num));
        return;
    }
    if (typeof number !== "number") return console.log("Not a number");
    if (!Number.isInteger(number)) return console.log("is not prime number");
    if (number % 2 === 0 && number > 2) return console.log(number + " is not prime number");
    if (number < 2) return console.log(number + " is not prime number");
    for (let i = 3; i <= Math.sqrt(number); i += 2) {
        if (number % i === 0) return console.log(number + " is not prime number");
    }
    return console.log(number + " is prime number");
}