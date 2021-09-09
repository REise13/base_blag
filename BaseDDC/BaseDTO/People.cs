using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BaseDTO
{
    public class DTO_People_Reg
    {
        public int Id { get; set; }
        public string SName { get; set; }
        public string Name { get; set; }
        public string Patr { get; set; }
        public int Year { get; set; }
        public string Inn { get; set; }
        public string Email { get; set; }
        public string Phone { get; set; }
        public string Passport { get; set; }
        public int IdCity { get; set; }
        public int IdGender { get; set; }
        public List<int> id_Categories { get; set; }
    }
    public class DTO_People_Get
    {

        public int Id { get; set; }
        public string SName { get; set; }
        public string Name { get; set; }
        public string Patr { get; set; }
        public int Year { get; set; }
        public string Inn { get; set; }
        public string Email { get; set; }
        public string Phone { get; set; }
        public string Passport { get; set; }     
        public DTO_City IdCityNavigation { get; set; }
        public DTO_Gender IdGenderNavigation { get; set; }
    }


    public class DTO_People_Update
    {

        public int Id { get; set; }
        public string SName { get; set; }
        public string Name { get; set; }
        public string Patr { get; set; }
        public int Year { get; set; }
        public string Inn { get; set; }
        public string Email { get; set; }
        public string Phone { get; set; }
        public string Passport { get; set; }
        public int IdCity { get; set; }
        public int IdGender { get; set; }
    }
}
