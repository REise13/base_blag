using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using BaseDDC.model;
using BaseDTO;
using Newtonsoft.Json;
using Microsoft.EntityFrameworkCore.Diagnostics;
namespace BaseDDC.Controllers
{
    [Route("People")]
    [ApiController]
    public class PeopleController : ControllerBase
    {
        public readonly baseddcContext _context = new baseddcContext();


        [Route("PeopleReg")]
        [HttpPost]
        public IActionResult PplReg([FromBody] DTO_Auth_Obj auth)
        {
            try
            {
                DTO_People_Reg new_people = JsonConvert.DeserializeObject<DTO_People_Reg>(auth.obj.ToString());
                People ppl = AutoMapper.Mapper.Map<DTO_People_Reg, People>(new_people);
                Profile profile = new Profile();
                profile.IdPeopleNavigation = ppl;

                List<Crosscategory> cross = new List<Crosscategory>();
                foreach (int Category in new_people.id_Categories)
                {
                    cross.Add(new Crosscategory() { IdProfileNavigation = profile, IdCategory = Category });
                }
                profile.Crosscategory = cross;
                profile.IdTypeHeating = 1;
                profile.NumbOfChild = 0;
                profile.DestroyedHouse = 0;
                profile.ForcedMigrant = 0;
                profile.IdTypeOfHouse = 1;
                ppl.Profile.Add(profile);
                _context.People.Add(ppl);
                _context.SaveChanges();
                return Ok(profile.Id);
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }

        [Route("PeopleRegMass")]
        [HttpPost]
        public IActionResult PplGerList([FromBody] DTO_Auth_Obj auth)
        {
            try
            {
                List<DTO_People_Reg> new_people = JsonConvert.DeserializeObject<List<DTO_People_Reg>>(auth.obj.ToString());
                List<Profile> profiles = new List<Profile>();
                foreach (DTO_People_Reg a in new_people)
                {
                    Profile b = new Profile();
                    People people = AutoMapper.Mapper.Map<DTO_People_Reg, People>(a);
                    b.IdPeopleNavigation = people;
                    List<Crosscategory> cross = new List<Crosscategory>();
                    foreach (int Category in a.id_Categories)
                    {
                        cross.Add(new Crosscategory() { IdProfileNavigation = b, IdCategory = Category });
                    }
                    b.Crosscategory = cross;
                    b.IdTypeHeating = 1;
                    b.NumbOfChild = 0;
                    b.DestroyedHouse = 0;
                    b.ForcedMigrant = 0;
                    b.IdTypeOfHouse = 1;
                    profiles.Add(b);

                }
                _context.Profile.AddRange(profiles);
                _context.SaveChanges();
                return Ok();
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }
        [HttpPost]
        [Route("Delete/{id}")]
        public IActionResult DeletePeople([FromBody]DTO_Auth_Obj t, int id)
        {
            People b;
            try
            {
                b = _context.People.Find(id);
                _context.People.Remove(b);
                _context.SaveChanges();
                return Ok();
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }
        [HttpPost]
        [Route("UpdatePersonal")]
        public IActionResult UpdatePersonal([FromBody]DTO_Auth_Obj t)
        {
            DTO_People_Update personal;
            try
            {
                personal = JsonConvert.DeserializeObject<DTO_People_Update>(t.obj.ToString());
            }
            catch
            {
                return BadRequest("Не удалось распознать полученный объект");
            }

            try
            {
                People a = _context.People.Find(personal.Id);
                AutoMapper.Mapper.Map(personal, a);
                _context.Update(a);
                _context.SaveChanges();
                return Ok();
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }

        
    }
}