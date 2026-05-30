export class InputMaskUtils {
	applyPhoneMask(input) {
		let value = input.target.value.replace(/\D/g, ""); // Remove tudo que não é dígito

		value = value.replace(
			/^(\d{0,2})(\d{0,2})(\d?)(\d{0,4})(\d{0,4}).*/,
			(_, country, ddd, ninth, part1, part2) => {
				let formatted = "";

				if (country) formatted += `+${country}`;

				if (ddd) {
					formatted += `${formatted ? " " : ""}(${ddd}${ddd.length === 2 ? ")" : ""}`;
				}

				if (ninth) formatted += `${formatted ? " " : ""}${ninth}`;
				if (part1) formatted += `${formatted ? " " : ""}${part1}`;
				if (part2) formatted += `-${part2}`;

				return formatted;
			},
		);

		input.target.value = value;
	}

	applyCpfMask(input) {
		let value = input.target.value.replace(/\D/g, ""); // Remove tudo que não é dígito

		value = value
			.replace(/(\d{3})(\d)/, "$1.$2") // Coloca ponto entre o terceiro e o quarto dígitos
			.replace(/(\d{3})(\d)/, "$1.$2") // Coloca ponto entre o sexto e o sétimo dígitos
			.replace(/(\d{3})(\d)/, "$1-$2") // Coloca hífen entre o nono e o décimo dígitos
			.slice(0, 14); // Limita a 14 caracteres (incluindo formatação)

		input.target.value = value;
	}
}
