package met;

public class Student {
	private String ime;
	private String prezime;
	private String brojIndeksa;
	private String adresa;
	private String email;
	private String sifra;
	private String jmbg;
	
	public String getIme() {
		return ime;
	}
	public void setIme(String ime) {
		this.ime = ime;
	}
	public String getPrezime() {
		return prezime;
	}
	public void setPrezime(String prezime) {
		this.prezime = prezime;
	}
	public String getBrojIndeksa() {
		return brojIndeksa;
	}
	public void setBrojIndeksa(String brojIndeksa) {
		this.brojIndeksa = brojIndeksa;
	}
	public String getAdresa() {
		return adresa;
	}
	public void setAdresa(String adresa) {
		this.adresa = adresa;
	}
	public String getEmail() {
		return email;
	}
	public void setEmail(String email) {
		this.email = email;
	}
	public String getSifra() {
		return sifra;
	}
	public void setSifra(String sifra) {
		this.sifra = sifra;
	}
	public String getJmbg() {
		return jmbg;
	}
	public void setJmbg(String jMBG) {
		jmbg = jMBG;
	}
	
	@Override
	public String toString() {
		return "Student [ime=" + ime + ", prezime=" + prezime
				+ ", brojIndeksa=" + brojIndeksa + ", adresa=" + adresa
				+ ", email=" + email + ", sifra=" + sifra + ", JMBG=" + jmbg
				+ "]";
	}
}
